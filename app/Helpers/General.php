<?php 



function get_languages(){
    \App\Models\Language::active()->selection()->get();
}

function get_default_lang()
{
    return Config::get('app.locale');
}