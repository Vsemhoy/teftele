<?php

namespace App\Http\Controllers\Auth;

use App\Http\Components\com_logger\Logger;
use App\Http\Controllers\BaseHelpers\Input;
use App\Http\Controllers\BaseHelpers\TextHelpers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class UsersDb extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    public static function GetUserItem($id)
    {
        $result = DB::table(env('TABLE_USERS'))->where('id', $id)->first();
        return $result;
    }
    public static function GetUserMailByLogin($login){
        $result = DB::table(env('TABLE_USERS'))->where('login', $login)->first();
        if ($result != null){
            return $result->email;
        } else {
            return null;
        }
    }

    public static function GetUserList($offset, $limit, $state = '', $text = null)
    {
        if ($text == null){
            if ($state == null){
    
                $users = DB::table(env('TABLE_USERS'))->orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();
                return $users;
            }
            else 
            {
                $users = DB::table(env('TABLE_USERS'))->where('state', $state)->orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();
                return $users;
            }

        } else {
            if ($state == ''){
                $users = DB::table(env('TABLE_USERS'))
                ->where('name', 'LIKE', '%' . $text . '%')
                ->orwhere('name', 'LIKE', '%' . $text . '%')
                ->orwhere('nick_name', 'LIKE', '%' . $text . '%')
                ->orwhere('email', 'LIKE', '%' . $text . '%')
                ->orwhere('login', 'LIKE', '%' . $text . '%')
                ->orwhere('company', 'LIKE', '%' . $text . '%')
                ->orwhere('info', 'LIKE', '%' . $text . '%')
                ->orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();
                return $users;
            }
            else 
            {
                echo "case 4 , state " . $state;
                $users = DB::table(env('TABLE_USERS'))
                ->where(function ($query) use ($text)
                {
                    $query->where('name', 'LIKE', '%' . $text . '%')
                    ->orwhere('name', 'LIKE', '%' . $text . '%')
                    ->orwhere('nick_name', 'LIKE', '%' . $text . '%')
                    ->orwhere('email', 'LIKE', '%' . $text . '%')
                    ->orwhere('login', 'LIKE', '%' . $text . '%')
                    ->orwhere('company', 'LIKE', '%' . $text . '%')
                    ->orwhere('info', 'LIKE', '%' . $text . '%');
                }
                )->where('state', '=', $state)
                ->orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();
                return $users;
            }
        }
    }

    public static function GetLastMonthUserList($offset = 3)
    {
        $date = date("Y-m-d", strtotime("-" . $offset . " Months"));

        $users = DB::table(env('TABLE_USERS'))->where('created_at', '>=', $date)->orderBy('id', 'DESC')->get();
        return $users;
    }

    public static function GetNickedUserList()
    {
        $users = DB::table(env('TABLE_USERS'))->where('nick_name', '!=', null)->where('nick_name', '!=', "")->orderBy('id', 'DESC')->get(['id', 'nick_name', 'email']);
        return $users;
    }

    public static function GetUserListCount($state = null, $text = null)
    {
        $count = "";
        if ($text == null){
            if ($state == null)
            {
                $count = DB::table(env('TABLE_USERS'))->count();
            } 
            else 
            {
                $count = DB::table(env('TABLE_USERS'))->where('state', $state)->count();
            }
        } else {
            if ($state == null){

                $users = DB::table(env('TABLE_USERS'))
                ->where('name', 'LIKE', '%' . $text . '%')
                ->orwhere('name', 'LIKE', '%' . $text . '%')
                ->orwhere('nick_name', 'LIKE', '%' . $text . '%')
                ->orwhere('email', 'LIKE', '%' . $text . '%')
                ->orwhere('login', 'LIKE', '%' . $text . '%')
                ->orwhere('company', 'LIKE', '%' . $text . '%')
                ->orwhere('info', 'LIKE', '%' . $text . '%')
                ->count();
                return $users;
            }
            else 
            {
                $users = DB::table(env('TABLE_USERS'))->where('state', $state)
                ->where('name', 'LIKE', '%' . $text . '%')
                ->orwhere('name', 'LIKE', '%' . $text . '%')
                ->orwhere('nick_name', 'LIKE', '%' . $text . '%')
                ->orwhere('email', 'LIKE', '%' . $text . '%')
                ->orwhere('login', 'LIKE', '%' . $text . '%')
                ->orwhere('company', 'LIKE', '%' . $text . '%')
                ->orwhere('info', 'LIKE', '%' . $text . '%')
                ->where('state', $state)->count();
                return $users;
            }
        }
        return $count;
    }




    public static function WriteNewUserItem($object, $user)
    {
        if (strlen($object->password) < 4){         
            $object->id = null;
            return $object;
        }

        $password = Hash::make(Input::filterMe("TEXT", $object->password, 30));

        $role = Input::filterMe("INT", $object->role);
        if ($object->state == 1 && $user->role < 4){
            $object->state = 0;
            $role = 1;
        }

        if (self::CheckLoginDuplicates($object->login)) {
            $object->id = null;
            return $object;
        }
        if (self::CheckMailDuplicates($object->email)) {
            $object->id = null;
            return $object;
        }

    try {
        $newId  = DB::table(env('TABLE_USERS'))->insertGetId(
        [
            "name"        => Input::filterMe("TEXT", $object->name, 100),
            "nick_name"   => Input::filterMe("TEXT", $object->nick_name, 100),
            "login"       => Input::filterMe("TEXT", $object->login, 100),
            "email"       => Input::filterMe("TEXT", $object->email, 100),
            "password"    => $password,
            "phone_numbers"  => Input::filterMe("TEXT", $object->phone, 500),
            "role"           => $role,
            "state"      => $object->state,
            "service"    => Input::filterMe("TEXT",  $object->services),
            "company"    => Input::filterMe("TEXT",  $object->company),
            "info"       => Input::filterMe("TEXT", $object->info, 500),
            "gen"        => Input::filterMe("INT",  $object->gen),
            "updator"    => $user->id,
            "creator"    => $user->id,
        ]
      );

    } catch(\Illuminate\Database\QueryException $e){
        $errorCode = $e->errorInfo[1];
        if($errorCode == '1062'){
           return 'Your message may be a duplicate. Did you refresh the page? We blocked that submission. If you feel this was in error, e-mail us or call us.';
        }
        else{
         return $e->getMessage();
        }
    }
        $object->id = $newId;
      return $object;
}



    public static function UpdateUserItem($object, $user, $file) /// NOT CHANGED
    {
        $userId = Input::filterMe("INT", $object->id);
        // $fileNameCur = Input::filterMe("URL", $object->curfilename, 100);
        // $loadedFileName = "";
        // $fullPath = "";
        // $fileType = "";
        // $tempName = "";
        // $fileSize = 0;
        
        $password = null;
        $pass = Input::filterMe("TEXT", $object->password, 30);
        if (strlen($pass) > 3){
            $password = Hash::make(Input::filterMe("TEXT", $object->password, 30));
        }

        $role = Input::filterMe("INT", $object->role);
        if ($object->state == 1 && $user->role < 4){
            $object->state = 0;
            $role = 1;
        }

        if (self::CheckLoginDuplicates($object->login, $object->id)) {
            $object->id = null;
            return $object;
        }
        if (self::CheckMailDuplicates($object->email, $object->id)) {
            $object->id = null;
            return $object;
        }

        // if (count($file) > 0){
        //     $loadedFileName = reset($file)["name"];
        //     $fullPath = reset($file)["full_path"];
        //     $fileType = reset($file)["type"];
        //     $tempName = reset($file)["tmp_name"];
        //     $fileSize = reset($file)["size"];
        // }

        // $oldfilename = Input::filterMe("URL", $object->curfilename, 120);
        // $directory = $userId;

        // $newDir = $_SERVER['DOCUMENT_ROOT'] . UserAuth::ADMIN_FOLDER . $userId . DIRECTORY_SEPARATOR;
        // // Replace file or load new file
        // if ($loadedFileName != "" && $oldfilename != $loadedFileName && $fileNameCur != "")
        // {
        //     // Erase old file
        //     if ($oldfilename != ""){
        //         $exists = APFH::IfFileExists($newDir . $oldfilename);
        //         if ($exists){
        //             unlink($newDir . $oldfilename);
        //         }
        //     }
        //     // Write new file
        //     if ($fileNameCur != ""){
        //         $direx = APFH::IfFileExists($newDir);
        //         if (!$direx)
        //         {
        //             // sudo chmod -R 755 /opt/lampp/htdocs
        //             // chmod($_SERVER['DOCUMENT_ROOT'] . UserAuth::ADMIN_FOLDER, 0777);
        //             mkdir($newDir);
        //         }
        //         $exists = APFH::IfFileExists($newDir . $fileNameCur);
        //         if ($exists)
        //         {
        //             $_name = explode(".", $fileNameCur);
        //             $fileNameCur = $_name[0] . "_" . rand(100, 9999) . "." . $_name[count($_name) - 1];
        //         }
        //         move_uploaded_file($tempName, $newDir . $loadedFileName);
        //         self::ResizeForAvatar($newDir . $loadedFileName);
        //         $object->curfilename = $loadedFileName;
        //         $fileNameCur = $loadedFileName;
        //     }
        //     else {
        //         $object->curfilename = "";
        //         $fileNameCur = "";
        //     }
        // } elseif ($loadedFileName == "" && $oldfilename != $fileNameCur){
        //     // case need to Rename File
        //     if ($fileNameCur != ""){
        //         $exists = APFH::IfFileExists($newDir . $fileNameCur);
        //         if ($exists)
        //         {
        //             $_name = explode(".", $fileNameCur);
        //             $fileNameCur = $_name[0] . "_" . rand(100, 9999) . "." . $_name[count($_name) - 1];
        //         }
        //         rename( $newDir . $oldfilename, $newDir . $fileNameCur);
        //         $object->curfilename = $fileNameCur;
        //     } else {
        //         // Remove file
        //         unlink($newDir . $oldfilename);
        //         $object->curfilename = "";
        //         $fileNameCur = "";
        //     }
        // }

        $arrToUpdate = [
            "name"      => Input::filterMe("TEXT", $object->name, 100),
            "nick_name" => Input::filterMe("TEXT", $object->nick_name, 100),
            "login"     => Input::filterMe("TEXT", $object->login, 100),
            "email"     => Input::filterMe("TEXT", $object->email, 100),
            "phone_numbers"     => Input::filterMe("TEXT", $object->phone, 500),
            "role"      => $role,
            "state"     => $object->state,
            "service"   => Input::filterMe("TEXT",  $object->services),
            "company"   => Input::filterMe("TEXT",  $object->company),
            "info"      => Input::filterMe("TEXT", $object->info, 500),
            "gen"      => Input::filterMe("INT",  $object->gen),
            "updator"   => $user->id,
        ];
        if ($password != null){
            $arrToUpdate["password"] = $password;
        }
        

        $affected = DB::table(env('TABLE_USERS'))
        ->where("id", $userId)
        ->update($arrToUpdate);
        // $a = session('LoggedUser');
        // if ($object->id == session('LoggedUser')){
        //     session()->put('admin_avatar', $object->curfilename);
        // }
        // if ($object->curfilename == null){
        //     $object->curfilename = "";
            
        // }

          return $object;
    }

//     public static function DeleteUserItem($obj, $userObj)
//     {
//         if ($user->role < 4){
//             return 1;
//         }        
//         $id = Input::filterMe("INT", $obj->id);
//         if ($id == 1){
//             return 1;
//         }
//         $item = self::GetUserItem($id);
//         if ($item == null){
//             return 0;
//         }
//         if ($item->avatar != null){
//             if ($item->avatar != null){
//                 $newDir = $_SERVER['DOCUMENT_ROOT'] . UserAuth::ADMIN_FOLDER . $id . DIRECTORY_SEPARATOR . $item->avatar;
//                     $exists = APFH::IfFileExists($newDir);
//                     if ($exists){
//                         unlink($newDir);
//                     }

//             }
//             $Dir = $_SERVER['DOCUMENT_ROOT'] . UserAuth::ADMIN_FOLDER . $id . DIRECTORY_SEPARATOR;
//             $exists = APFH::IfFileExists($Dir);
//             if ($exists){
//                 rmdir($Dir);
//             }
//         }

//         $result = DB::table(env('TABLE_ADMINS'))->where('id', $id)->delete();
//         return $obj;
//     }


    // Not totally remove, but erase all files and rename values (It allows user to re-register)
    public static function DeleteUserItem($object, $userObj){
    $userId = Input::filterMe("INT", $object->id);
        $item = self::GetUserItem($userId);
        $rand = rand(10000, 99999);
        $name = Input::filterMe("TEXT", $item->name, 60) . "_" .   $rand . " [DELETED]";
        $login = Input::filterMe("TEXT", $item->login, 60) . "_" . $rand . " [DELETED]";
        $email = Input::filterMe("TEXT", $item->email, 60) . "_" . $rand . " [DELETED]";
        $arrToUpdate = [
            "is_deleted" => 1,
            "name" => $name,
            "email" => $email,
            "login" => $login
        ];
        $affected = DB::table(env('TABLE_USERS'))
        ->where("id", $userId)
        ->update($arrToUpdate);
        return $object;
    }

// return false if Busy
    public static function CheckNameDuplicates($name, $id = null){
        $notFree = false;
        $result = null;
        if ($id != null){
            $result = DB::table(env('TABLE_USERS'))->where('name', $name)->where('id', '!=', $id)->first();
        }
        else {
            $result = DB::table(env('TABLE_USERS'))->where('name', $name)->first();
        }
        if ( $result != null ) {
            $notFree = true;
        }
        return $notFree;
    }
    public static function CheckLoginDuplicates($name, $id = null){
        $notFree = false;
        $result = null;
        if ($id != null){
            $result = DB::table(env('TABLE_USERS'))->where('login', $name)->where('id', '!=', $id)->first();
        }
        else {
            $result = DB::table(env('TABLE_USERS'))->where('login', $name)->first();
        }
        if ( $result != null ) {
            $notFree = true;
        }
        return $notFree;
    }
    public static function CheckMailDuplicates($name, $id = null){
        $notFree = false;
        $result = null;
        if ($id != null){
            $result = DB::table(env('TABLE_USERS'))->where('email', $name)->where('id', '!=', $id)->first();
        }
        else {
            $result = DB::table(env('TABLE_USERS'))->where('email', $name)->first();
        }
        if ( $result != null ) {
            $notFree = true;
        }
        return $notFree;
    }

    public static function ResizeForAvatar($imagePath){

        // THIS CLASS IS BROKEN, NEED TO WRITE NEW ONE/admin/apps/versions
        // *** 1) Initialise / load image
        // $resizeObj = new Resizer($imagePath);

        // // *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
        // $resizeObj -> resizeImage(150, 150, 'crop');

        // // *** 3) Save image ('image-name', 'quality [int]')
        // $resizeObj -> saveImage($imagePath, 100);
    }


    public static function IncreaseUserLogins($userId){
        $object = self::GetUserItem($userId);
        if ($userId == null) {
            return;}
        $counter = $object->login_counter;
        if ($counter > 2000000000){
            $counter = 0;
        }
        $timestamp = date("Y-m-d H:i:s");
        $counter++;
            $arrToUpdate = [
                "logined_at" => $timestamp,
                "login_counter" => $counter,
            ];
            $affected = DB::table(env('TABLE_USERS'))
            ->where("id", $userId)
            ->update($arrToUpdate);
            return $object;
        }

        public static function UpdateSessionKey($userId, $token){
            $arrToUpdate = [
                "last_session_key" => $token,
            ];
            $affected = DB::table(env('TABLE_USERS'))
            ->where("id", $userId)
            ->update($arrToUpdate);
            return $affected;
        }
}
