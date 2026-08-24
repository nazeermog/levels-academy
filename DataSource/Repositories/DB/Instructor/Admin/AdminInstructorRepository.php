<?php

namespace DataSource\Repositories\DB\Instructor\Admin;


use DataSource\Entities\User\User;
use Illuminate\Support\Facades\Storage;
use DataSource\Entities\Instructor\Instructor;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class AdminInstructorRepository
{
    use AdminCRUDGenericRepository;

    protected $model = Instructor::class;

    public static function list()
    {
        return Instructor::all();
    }
    public function index()
    {
        return $this->getModel()->orderBy('user_id', 'desc')->paginate(20);
    }
    public function destroy($user_id)
    {
        return $this->getModel()->destroy($user_id);
    }

    public static function InstructorForCourse($courses)
    {

        // Batch-load all instructors in one query instead of one query per course (N+1).
        $instructorIds = collect($courses)->pluck('instructor_id')->filter()->unique()->all();
        $instructorsByUserId = Instructor::whereIn('user_id', $instructorIds)->get()->keyBy('user_id');

        $instructors = [];
        foreach ($courses as $course) {
            $instructors[$course->id] = $instructorsByUserId->get($course->instructor_id);
        }
        return $instructors;
    }
    public static function InstructorForOneCourse($course)
    {
        $instructorId = $course->instructor_id;
        $instructor = Instructor::where('user_id', $instructorId)->first();
        return $instructor;
    }



    public function store($request, $data)
    {
        $instructor = $this->getModel();
        foreach (localeSupported() as $locale) {
            $instructor->translateOrNew($locale)->spec = $data['spec-' . $locale];
            $instructor->translateOrNew($locale)->about = $data['about-' . $locale];
            $instructor->translateOrNew($locale)->country = $data['country-' . $locale];
        }

        $instructor->user_id = $data['user_id'];
        $user = User::where('id', $instructor->user_id)->first();
        $instructor->first_name = $user->first_name;
        $instructor->last_name = $user->last_name;
        $user->organization_id = $data['organization_id'] ?? null;

        if ($request->hasFile('avatar')) {
            $videoPath = $request->file('avatar')->store('public/photos');
            $instructor->avatar = Storage::url($videoPath);
        }

        $instructor->save();

        $user->role = 'instructor';
        $user->save();
    }

    public function update($request, $data)
    {
        $instructor = Instructor::find($data['model_id']);
        foreach (localeSupported() as $locale) {
            $instructor->translateOrNew($locale)->spec = $data['spec-' . $locale];
            $instructor->translateOrNew($locale)->about = $data['about-' . $locale];
            $instructor->translateOrNew($locale)->country = $data['country-' . $locale];
        }
        $instructor->user_id = $data['user_id'];
        $user = User::where('id', $instructor->user_id)->first();
        $instructor->first_name = $user->first_name;
        $instructor->last_name = $user->last_name;
        $user->organization_id = $data['organization_id'] ?? null;
        if ($request->hasFile('avatar')) {
            $videoPath = $request->file('avatar')->store('public/photos');
            $instructor->avatar = Storage::url($videoPath);
        }

        $instructor->save();

        $user->role = 'instructor';
        $user->save();
    }
}
