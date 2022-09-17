<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

class GlobalSeeder extends Seeder{
    public function setInitialPhoto($name): string
    {
        $path = public_path('storage/avatars/');
        $fontPath = public_path('fonts/Oliciy.ttf');
        $char = strtoupper($name[0]);
        $newAvatarName = rand(12,34353).time().'_avatar.png';
        $dest = $path.$newAvatarName;

        $createAvatar = makeAvatar($fontPath,$dest,$char);
        return $createAvatar ? $newAvatarName : '';
    }
}
