<?php
use App\Models\Employee;
use App\Models\User;


function get_presenter($id) {
    $presenter = Employee::find($id);
    if(is_null($presenter)) {
        return 'NULL';
    }

    return $presenter->firstnames.' '.$presenter->surname;
}

function get_presenter_byUserId($id) {
    $presenter = Employee::where('user_id',$id)->first();
    if(is_null($presenter)) {
        return 'NULL';
    }

    return $presenter->firstnames.' '.$presenter->surname;
}

function get_author($id) {
    $presenter = Employee::where('user_id', $id)->first();
    if(is_null($presenter)) {
        return 'NULL';
    }

    return $presenter->firstnames.' '.$presenter->surname;
}

function get_user($id) {
    $user = User::find($id);
    if(is_null($user)) {
        return 'NULL';
    }

    return $user->name;
}
