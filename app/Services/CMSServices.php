<?php

namespace App\Services;

class CMSServices
{
    public function types(): CMSTypes
    {
        return new CMSTypes;
    }

    public function authors(): CMSAuthors
    {
        return new CMSAuthors;
    }

    public function themes(): CMSThemes
    {
        return new CMSThemes;
    }

    public function formFields(): CMSFormFields
    {
        return new CMSFormFields;
    }
}
