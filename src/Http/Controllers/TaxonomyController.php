<?php

declare(strict_types=1);
/**
 * Contains the TaxonomyController class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-09-22
 *
 */

namespace Vanilo\Admin\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Konekt\AppShell\Http\Controllers\BaseController;
use Vanilo\Admin\Contracts\Requests\CreateTaxonomy;
use Vanilo\Admin\Contracts\Requests\SyncModelTaxons;
use Vanilo\Admin\Contracts\Requests\UpdateTaxonomy;
use Vanilo\Admin\Traits\CreatesMediaFromRequestImages;
use Vanilo\Category\Contracts\Taxonomy;
use Vanilo\Category\Models\TaxonomyProxy;

class TaxonomyController extends BaseController
{
    use CreatesMediaFromRequestImages;

    public function index()
    {
        return view('vanilo::taxonomy.index', [
            'taxonomies' => TaxonomyProxy::all()
        ]);
    }

    public function create()
    {
        return view('vanilo::taxonomy.create', [
            'taxonomy' => app(Taxonomy::class)
        ]);
    }

    public function store(CreateTaxonomy $request)
    {
        try {
            $taxonomy = TaxonomyProxy::create($request->except('images'));
            flash()->success(__(':name has been created', ['name' => $taxonomy->name]));
            $this->createMedia($taxonomy, $request);
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.taxonomy.index'));
    }

    public function show(Taxonomy $taxonomy)
    {
        return view('vanilo::taxonomy.show', ['taxonomy' => $taxonomy]);
    }

    public function edit(Taxonomy $taxonomy)
    {
        return view('vanilo::taxonomy.edit', ['taxonomy' => $taxonomy]);
    }

    public function update(Taxonomy $taxonomy, UpdateTaxonomy $request)
    {
        try {
            $taxonomy->update($request->all());

            flash()->success(__(':name has been updated', ['name' => $taxonomy->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.taxonomy.index'));
    }

    public function destroy(Taxonomy $taxonomy)
    {
        try {
            $name = $taxonomy->name;
            $taxonomy->delete();

            flash()->warning(__(':name has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('vanilo.admin.taxonomy.index'));
    }

    public function sync(Taxonomy $taxonomy, SyncModelTaxons $request)
    {
        $taxonIds = $request->getTaxonIds();
        $model = $request->getFor();

        foreach (TaxonomyProxy::where('id', '<>', $taxonomy->id)->get() as $foreignTaxonomy) {
            $taxonIds = array_merge(
                $taxonIds,
                $model->taxons()->byTaxonomy($foreignTaxonomy)->get(['id'])->pluck('id')->toArray()
            );
        }

        DB::transaction(function () use ($taxonIds, $model, $taxonomy) {
            $model->taxons()->byTaxonomy($taxonomy)->sync($taxonIds);
            $model->touch();
        });


        return redirect(route(sprintf('vanilo.admin.%s.show', shorten(get_class($model))), $model));
    }
}
