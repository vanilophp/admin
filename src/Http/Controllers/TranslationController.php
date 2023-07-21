<?php

declare(strict_types=1);

/**
 * Contains the TranslationController class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-07-21
 *
 */

namespace Vanilo\Admin\Http\Controllers;

use Vanilo\Admin\Contracts\Requests\CreateTranslationForm;

class TranslationController
{
    public function index()
    {
        return view('vanilo::translation.index', [
            'translations' => [],
        ]);
    }

    public function create(CreateTranslationForm $request)
    {
        $translation = new \stdClass(); //app(Translation::class);
        $translation->language = $request->query('lang');

        $schema = new \stdClass();
        $schema->hasAdditionalFields = false;
        $schema->usesSlug = true;
        $schema->getTitle = fn ($m) => $m->name;

        return view('vanilo::translation.create', [
            'translation' => $translation,
            'translatable' => $request->getFor(),
            'schema' => $schema,
        ]);
    }
}
