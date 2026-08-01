<?php

namespace DataSource\Entities\Worksheet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * A downloadable worksheet (PDF / Word) attached to a course step.
 * Used as a CourseStep stepable_type of "Worksheets".
 */
class Worksheet extends Model
{
    protected $table = 'worksheets';

    protected $fillable = [
        'title',
        'description',
        'file',
        'original_name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Absolute path of the stored file on disk (null when missing).
     * `file` holds the public URL, e.g. /storage/worksheets/abc.pdf
     */
    public function absolutePath(): ?string
    {
        if (!$this->file) {
            return null;
        }

        $relative = ltrim(str_replace('/storage/', '', $this->file), '/');
        $path = Storage::disk('public')->path($relative);

        return is_file($path) ? $path : null;
    }

    /**
     * Friendly filename for downloads (falls back to a slug of the title).
     */
    public function downloadName(): string
    {
        if ($this->original_name) {
            return $this->original_name;
        }

        $ext = pathinfo((string) $this->file, PATHINFO_EXTENSION) ?: 'pdf';

        return Str::slug($this->title ?: 'worksheet').'.'.$ext;
    }
}
