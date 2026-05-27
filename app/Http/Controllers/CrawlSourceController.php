<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CrawlSource;

class CrawlSourceController extends Controller
{
    public function index()
    {
        $sources = CrawlSource::orderBy('created_at', 'desc')->get();
        return view('crawlsources', compact('sources'));
    }

    // API endpoint cho polling
    public function data()
    {
        $sources = CrawlSource::orderBy('created_at', 'desc')->get();

        $hash = md5($sources->map(function ($s) {
            return $s->id . $s->is_active . $s->is_done . $s->last_run_at;
        })->join('|'));

        return response()->json([
            'hash'    => $hash,
            'sources' => $sources,
        ]);
    }

    public function store(Request $request)
    {
        $this->validateSource($request);
        CrawlSource::create($this->extractData($request));
        return redirect('/crawl-sources')->with('success', 'Thêm nguồn thành công');
    }

    public function toggleActive($id)
    {
        $source = CrawlSource::findOrFail($id);
        $source->update(['is_active' => !$source->is_active]);
        return redirect('/crawl-sources')
            ->with('success', $source->is_active ? 'Đã bật nguồn' : 'Đã tắt nguồn');
    }

    public function destroy($id)
    {
        CrawlSource::findOrFail($id)->delete();
        return redirect('/crawl-sources')->with('success', 'Đã xóa nguồn');
    }

    // =========================
    // VALIDATE
    // =========================

    private function validateSource(Request $request): void
    {
        $rules = [
            'name'      => 'required|string|max:255',
            'url'       => 'required|url',
            'mode'      => 'required|in:interval,daily_times,once',
            'max_posts' => 'required|integer|min:1|max:50',
        ];

        if ($request->mode === 'interval') {
            $rules['interval_minutes'] = 'required|integer|min:1';
        }

        if ($request->mode === 'daily_times') {
            $rules['daily_times'] = 'required|string';
        }

        if ($request->mode === 'once') {
            $rules['run_at'] = 'required|date|after:now';
        }

        $request->validate($rules);
    }

    // =========================
    // EXTRACT DATA
    // =========================

    private function extractData(Request $request): array
    {
        $data = [
            'name'             => $request->name,
            'url'              => $request->url,
            'mode'             => $request->mode,
            'max_posts'        => $request->max_posts,
            'is_active'        => true,
            'is_done'          => false,
            'interval_minutes' => null,
            'daily_times'      => null,
            'run_at'           => null,
            'expires_at'       => null,
        ];

        if ($request->mode === 'interval') {
            $data['interval_minutes'] = $request->interval_minutes;
            $data['expires_at']       = $request->expires_at ?: null;
        }

        if ($request->mode === 'daily_times') {
            $times = array_filter(
                array_map('trim', explode(',', $request->daily_times))
            );
            $data['daily_times'] = implode(',', $times);
            $data['expires_at']  = $request->expires_at ?: null;
        }

        if ($request->mode === 'once') {
            $data['run_at'] = $request->run_at;
        }

        return $data;
    }
}