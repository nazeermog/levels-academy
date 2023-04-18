<?php

namespace DataSource\Repositories\API\Lesson;

use Vimeo\Vimeo;

class ApiLessonsRepository
{
    public static function apiCall()
    {
        $client = new Vimeo("9af40026d734d2022de83865e46c4b46ffbca1e4", "H0tWBT65QPdANLiLpbhxqFrLRoB90bXi8ZUyg0vVjlhyJmA80OVCIuBdEtutCEsg5IOdArVViKfgOujEJ0IBE4wqZXNAfuZjqW+xahtBMrCmBv83JmV4cvvHWxtgau+A", "49e89b7c9ebf4b5eebb757552c81a8b9");

        $response = $client->request('/tutorial', array(), 'GET');
        return $response;
}
}
