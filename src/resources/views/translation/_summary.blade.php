<?php

class TranslationMeta
{
    public function __construct(
        public readonly string $language,
        public readonly bool $exists = false,
        public readonly int $percent = 0,
        public readonly ?int $translationId = null,
        public readonly ?string $name = null,
    ) {
    }
}

function translations_of($t)
{
    $de = new TranslationMeta('de', true, 100, 1548, 'Kategorien');
    $fr = new TranslationMeta('fr', true, 8, 1557, 'Catégories');
    $nl = new TranslationMeta('nl');
    return [
        'de' => $de,
        'fr' => $fr,
        'nl' => $nl,
    ];
}
?>
<x-appshell::card>
    <x-slot:title>{{ __('Translations') }}</x-slot:title>

    <table class="table table-condensed table-borderless">
        <tbody>
        @foreach(translations_of($translatable) as $lang => $meta)
            <tr>
                <td>
                    <x-appshell::badge>{{ $lang }}</x-appshell::badge>
                </td>
                <td>
                    <small>{{ $meta->name ?? '-' }}</small>
                </td>
                <td valign="middle">
                    <small>{{ $meta->percent }}%</small>
                    @if(100 === $meta->percent)
                        &check;
                    @endif
                </td>
                <td class="text-end">
                    @if($meta->exists)
                        <x-appshell::button :href="route('vanilo.admin.translation.edit', $meta->translationId)"
                            size="xs" variant="secondary">{{ __('Edit') }}</x-appshell::button>
                    @else
                        <?php
                            $parameters = [
                                'for' => shorten($translatable::class),
                                'forId' => $translatable->id,
                                'lang' => $meta->language,
                            ];
                        ?>
                        <x-appshell::button :href="route('vanilo.admin.translation.create', $parameters)"
                            size="xs" variant="success">{{ __('Create') }}</x-appshell::button>
                    @endif
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
</x-appshell::card>
