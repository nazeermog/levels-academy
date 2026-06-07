<?php

namespace DataSource\Repositories\DB\Lesson\Admin;

use Carbon\Carbon;
use DataSource\Entities\Course\Course;
use DataSource\Entities\Lesson\Lesson;
use Illuminate\Support\Facades\Storage;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class AdminLessonRepository
{
    use AdminCRUDGenericRepository;

    protected $model = Lesson::class;

    public static function list()
    {
        return Lesson::all();
    }

    public function store($request, $data)
    {
        $lesson = $this->getModel();
        foreach (localeSupported() as $locale) {
            $lesson->translateOrNew($locale)->title = $data['title-' . $locale];
            $lesson->translateOrNew($locale)->desc = $data['desc-' . $locale];
            $lesson->translateOrNew($locale)->attachment_name = $data['attachment_name-' . $locale];
        }

        $lesson->time = $data['time'];
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('public/photos');
            $lesson->attachment = Storage::url($attachmentPath);
        } elseif ($request->filled('attachment')) {
            $attachmentInput = $request->input('attachment');
            $lesson->attachment = $attachmentInput;
        }

        if ($request->hasFile('url')) {
            $videoPath = $request->file('url')->store('public/photos');
            $lesson->url = Storage::url($videoPath);
        } elseif ($request->filled('url')) {
            $videoUrl = $request->input('url');
            if (strpos($videoUrl, 'https://www.youtube.com') === 0) {
                $videoId = getYoutubeVideoId($videoUrl);
                $lesson->url = 'https://www.youtube.com/embed/' . $videoId;
            } elseif (str_contains($videoUrl, 'vimeo.com')) {
                $videoId = getVimeoVideoId($videoUrl);
                $lesson->url = 'https://player.vimeo.com/video/' . $videoId;
            }
        }

        $lesson->save();
    }

    public function update($request, $data)
    {
        $lesson = Lesson::find($data['model_id']);
        foreach (localeSupported() as $locale) {
            $lesson->translateOrNew($locale)->title = $data['title-' . $locale];
            $lesson->translateOrNew($locale)->desc = $data['desc-' . $locale];
            $lesson->translateOrNew($locale)->attachment_name = $data['attachment_name-' . $locale];
        }

        $lesson->time = $data['time'];

        if ($request->hasFile('attachment')) {
            // Handle attachment update logic here, similar to what you did in the store function.
            $attachmentPath = $request->file('attachment')->store('public/photos');
            $lesson->attachment = Storage::url($attachmentPath);
        } elseif ($request->filled('attachment')) {
            $attachmentInput = $request->input('attachment');
            $lesson->attachment = $attachmentInput;
        }

        if ($request->hasFile('url')) {
            $videoPath = $request->file('url')->store('public/photos');
            $lesson->url = Storage::url($videoPath);
        } elseif ($request->filled('url')) {
            $videoUrl = $request->input('url');
            if (strpos($videoUrl, 'https://www.youtube.com') === 0) {
                $videoId = getYoutubeVideoId($videoUrl);
                $lesson->url = 'https://www.youtube.com/embed/' . $videoId;
            } elseif (str_contains($videoUrl, 'vimeo.com')) {
                $videoId = getVimeoVideoId($videoUrl);
                $lesson->url = 'https://player.vimeo.com/video/' . $videoId;
            }
        }

        $lesson->save();
    }

    public static function TotalLessonsHours($courses)
    {
        // Load all needed contents/steps/lessons in one batch instead of per course (N+1).
        $courseIds = collect($courses)->pluck('id')->all();
        $eagerCourses = Course::whereIn('id', $courseIds)
            ->with('courseContents.courseSteps.lesson')
            ->get();

        $totalLessonTimes = [];
        foreach ($eagerCourses as $course) {
            $totalLessonTime = 0;
            foreach ($course->courseContents as $courseContent) {
                foreach ($courseContent->courseSteps as $step) {
                    if ($step->stepable_type === 'Lessons' && $step->lesson) {
                        $totalLessonTime += $step->lesson->time;
                    }
                }
            }
            $totalLessonTimes[$course->id] = $totalLessonTime;
        }

        return $totalLessonTimes;
    }

    public static function SingleCoursTotalLesson($course)
    {
        $totalLessonTime = 0;
        $courseContents = $course->courseContents()->with('courseSteps.lesson')->get();
        foreach ($courseContents as $courseContent) {
            foreach ($courseContent->courseSteps as $step) {
                if ($step->stepable_type === 'Lessons' && $step->lesson) {
                    $totalLessonTime += $step->lesson->time;
                }
            }
        }

        return $totalLessonTime;
    }

    public static function SingleCoursTotalLessonCount($course)
    {
        $totalLessonTime = 0;
        $courseContents = $course->courseContents()->with('courseSteps.lesson')->get();
        foreach ($courseContents as $courseContent) {
            foreach ($courseContent->courseSteps as $step) {
                if ($step->stepable_type === 'Lessons' && $step->lesson) {
                    $totalLessonTime++;
                }
            }
        }
        return $totalLessonTime;
    }
}

function getYoutubeVideoId($url)
{
    parse_str(parse_url($url, PHP_URL_QUERY), $params);
    if (isset($params['v'])) {
        return $params['v'];
    }
    return null;
}

function getVimeoVideoId($url)
{
    $path = parse_url($url, PHP_URL_PATH);
    $segments = explode('/', trim($path, '/'));
    return $segments[0] ?? null;
}
