<?php

namespace DataSource\Traits\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

//use Modules\Media\Rpositories\Admin\AdminMediaRepository;

trait AdminCRUDGenericRepository
{
    public function index()
    {
        return $this->getModel()->orderBy('id', 'desc')->paginate(20);
    }

    protected function getModel()
    {
        return new $this->model;
    }


    protected function getTypeModel()
    {
        return new $this->typeModel;
    }

    public function store($data)
    {
        $data = Arr::except($data, ['image']);

        $object = $this->getModel()->create($data);
        foreach ($object->getTranslatableAttributes() as $attribute) {
            foreach (localeSupported() as $locale) {
                if (isset($data[$attribute . '-' . $locale]))
                    $object->translateOrNew($locale)->{$attribute} = $data[$attribute . '-' . $locale];
            }
        }
        $object->save();
//        $paths[] = array(
//            'src' => $object->addMediaFromBase64($data['image']),
//        );
//        foreach ($paths as $path) {
////            AdminMediaRepository::store($path, $object);
//            if (isset($object->image))
//                $object->image = $path['src'];
//            if (isset($object->icon))
//                $object->icon = $path['src'];
//        }
        return $object;
    }

    public function update($data)
    {
        $object = $this->getModel()->where('id', $data['model_id'])->first();
        $dataNew = Arr::except($data, ['model_id', 'image', 'images_old_deleted']);
        $object->update($dataNew);
        foreach ($object->getTranslatableAttributes() as $attribute) {
            foreach (localeSupported() as $locale) {
                if (isset($data[$attribute . '-' . $locale])) {
                    $object->translateOrNew($locale)->{$attribute} = $data[$attribute . '-' . $locale];
                }
            }
        }
        $object->save();
        if (isset($data['image'])) {
            $paths[] = array(
                'src' => $object->addMediaFromBase64($data['image']),
            );
            foreach ($paths as $path) {
//                AdminMediaRepository::store($path, $object);
                if (isset($object->image))
                    $object->image = $path['src'];
                if (isset($object->icon))
                    $object->icon = $path['src'];
            }
        }

        if (isset($data['images_old_deleted'])) {
            for ($i = 0; $i < count($data['images_old_deleted']); $i++) {
                $object->deleteMedia($data['images_old_deleted'][$i]);
            }
        }


        return $object;
    }

    public function destroy($id)
    {
        return $this->getModel()->destroy($id);
    }

    public function find($id)
    {
        if (null == $object = $this->getModel()->find($id)) {
            throw new ModelNotFoundException("Object not found");
        }

        return $object;
    }

    public function toggleStatus($data)
    {
        $object = $this->find($data['model_id']);
        $object->is_active = !$object->is_active;
        $object->save();
        return $object;
    }
}
