<?php

declare(strict_types=1);

/**
 * Contains the CreateAttachment class.
 *
 * @copyright   Copyright (c) 2026 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2026-10-29
 *
 */

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Konekt\AppShell\Http\Requests\HasFor;
use Vanilo\Admin\Contracts\Requests\CreateAttachment as CreateAttachmentContract;

class CreateAttachment extends FormRequest implements CreateAttachmentContract
{
    use HasFor;

    public static array $allowedExtensions = [
        'pdf', 'txt', 'csv', 'rtf', 'md', 'json', '7z', 'tar', 'tgz', 'gz', 'tar.gz',
        'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'odt', 'ods', 'odp',
        'jpg', 'jpeg', 'png', 'gif', 'webp',
        'zip', 'dwg', 'dxf', 'step', 'stp', 'stl',
    ];

    protected array $allowedFor = ['product', 'master_product', 'master_product_variant'];

    public function rules(): array
    {
        return array_merge($this->getForRules(), [
            'attachments' => 'required|array',
            'attachments.*' => 'file|extensions:' . implode(',', static::$allowedExtensions),
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }
}
