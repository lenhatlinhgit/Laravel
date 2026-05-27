@extends('layouts.admin')

@section('title', 'Crawl Sources')

@section('css')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
    .crawl-wrap {
        display: flex;
        gap: 20px;
        flex: 1;
        overflow: hidden;
    }

    /* ========================
       FORM
    ======================== */
    .crawl-form-box {
        width: 340px;
        flex-shrink: 0;
        background: #fff;
        padding: 20px;
        border: 1px solid rgba(0,0,0,0.05);
        overflow-y: auto;
        max-height: calc(100vh - 200px);
    }

    .crawl-form-box h3 {
        margin: 0 0 16px 0;
        font-size: 15px;
        color: #1f1717;
    }

    .crawl-form-box label {
        display: block;
        font-size: 12px;
        color: #777;
        margin-bottom: 4px;
        margin-top: 12px;
    }

    .crawl-form-box input,
    .crawl-form-box select {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #ddd;
        font-size: 13px;
        font-family: 'DM Sans', sans-serif;
        color: #1f1717;
        background: #fafafa;
        box-sizing: border-box;
    }

    .crawl-form-box input:focus,
    .crawl-form-box select:focus {
        outline: none;
        border-color: #1f1717;
        background: #fff;
    }

    .mode-section {
        margin-top: 10px;
        padding: 12px;
        background: #fafafa;
        border: 1px solid #eee;
    }

    .mode-section label {
        margin-top: 8px;
        font-size: 12px;
        color: #555;
    }

    /* Thêm giờ */
    .times-wrap {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 6px;
    }

    .time-tag {
        display: flex;
        align-items: center;
        gap: 4px;
        background: #1f1717;
        color: #fff;
        padding: 3px 8px;
        font-size: 12px;
    }

    .time-tag button {
        background: none;
        border: none;
        color: #fff;
        cursor: pointer;
        font-size: 12px;
        padding: 0;
        line-height: 1;
    }

    .add-time-row {
        display: flex;
        gap: 6px;
        margin-top: 6px;
    }

    .add-time-row input {
        flex: 1;
        padding: 6px 8px;
        font-size: 12px;
    }

    .btn-add-time {
        padding: 6px 10px;
        background: #1f1717;
        color: #fff;
        border: none;
        cursor: pointer;
        font-size: 12px;
        font-family: 'DM Sans', sans-serif;
    }

    /* expires */
    .expires-row {
        margin-top: 10px;
    }

    .expires-row .radio-group {
        display: flex;
        gap: 16px;
        margin-top: 4px;
        font-size: 13px;
        color: #555;
    }

    .expires-row .radio-group label {
        margin-top: 0;
        display: flex;
        align-items: center;
        gap: 4px;
        cursor: pointer;
    }

    .btn-submit {
        margin-top: 16px;
        width: 100%;
        padding: 9px;
        background: #1f1717;
        color: #fff;
        border: none;
        font-size: 13px;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
    }

    .btn-submit:hover { background: #333; }

    .btn-cancel {
        margin-top: 8px;
        width: 100%;
        padding: 9px;
        background: #f1f1f1;
        color: #555;
        border: none;
        font-size: 13px;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
    }

    .btn-cancel:hover { background: #e0e0e0; }

    /* ========================
       TABLE
    ======================== */
    .crawl-table-box {
        flex: 1;
        overflow-y: auto;
    }

    .crawl-table-box table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        font-size: 13px;
    }

    .crawl-table-box th {
        background: #1f1717;
        color: #fff;
        padding: 10px 12px;
        text-align: left;
        font-weight: 500;
    }

    .crawl-table-box td {
        padding: 10px 12px;
        border-bottom: 1px solid #f0f0f0;
        color: #1f1717;
        vertical-align: middle;
    }

    .crawl-table-box tr:hover td { background: #fafafa; }

    .badge { display: inline-block; padding: 2px 10px; font-size: 11px; font-weight: 600; }
    .badge-on   { background: #e6f4ea; color: #2e7d32; }
    .badge-off  { background: #fce8e8; color: #c62828; }
    .badge-done { background: #e8eaf6; color: #3949ab; }
    .badge-exp  { background: #fff3e0; color: #e65100; }

    .mode-badge {
        font-size: 11px;
        padding: 2px 8px;
        background: #f1f1f1;
        color: #555;
    }

    .url-cell {
        max-width: 180px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #777;
        font-size: 12px;
    }

    .schedule-detail {
        font-size: 11px;
        color: #888;
        margin-top: 2px;
    }

    .last-run { font-size: 11px; color: #aaa; }

    .action-btns { display: flex; gap: 6px; }

    .btn-edit {
        padding: 4px 10px; font-size: 12px;
        background: #f1f1f1; border: none;
        cursor: pointer; font-family: 'DM Sans', sans-serif; color: #1f1717;
    }
    .btn-edit:hover { background: #ddd; }

    .btn-toggle-on {
        padding: 4px 10px; font-size: 12px;
        background: #fce8e8; color: #c62828;
        border: none; cursor: pointer; font-family: 'DM Sans', sans-serif;
    }
    .btn-toggle-off {
        padding: 4px 10px; font-size: 12px;
        background: #e6f4ea; color: #2e7d32;
        border: none; cursor: pointer; font-family: 'DM Sans', sans-serif;
    }
    .btn-delete {
        padding: 4px 10px; font-size: 12px;
        background: #1f1717; color: #fff;
        border: none; cursor: pointer; font-family: 'DM Sans', sans-serif;
    }
    .btn-delete:hover { background: #333; }

    .alert-success {
        background: #e6f4ea; color: #2e7d32;
        padding: 10px 14px; font-size: 13px; margin-bottom: 14px;
    }
    .alert-error {
        background: #fce8e8; color: #c62828;
        padding: 10px 14px; font-size: 13px; margin-bottom: 14px;
    }
</style>
@endsection

@section('content')

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert-error">
        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
    </div>
@endif

<div class="crawl-wrap">

    {{-- ========================
         FORM
    ======================== --}}
    <div class="crawl-form-box">

        <h3 id="form-title">➕ Thêm nguồn mới</h3>

        <form action="/crawl-sources" method="POST" id="crawl-form">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">

            <label>Tên nguồn</label>
            <input type="text" name="name" id="input-name" placeholder="VD: VnExpress Du Lịch">

            <label>URL chuyên mục</label>
            <input type="url" name="url" id="input-url" placeholder="https://vnexpress.net/du-lich">

            <label>Số bài tối đa / lần</label>
            <input type="number" name="max_posts" id="input-max" value="5" min="1" max="50">

            <label>Chế độ lịch</label>
            <select name="mode" id="input-mode" onchange="switchMode(this.value)">
                <option value="interval">🔁 Lặp lại theo chu kỳ</option>
                <option value="daily_times">🕐 Khung giờ hàng ngày</option>
                <option value="once">📅 Hẹn 1 lần</option>
            </select>

            {{-- CHẾ ĐỘ 1: INTERVAL --}}
            <div class="mode-section" id="section-interval">
                <label>Chạy mỗi (phút)</label>
                <input type="number" name="interval_minutes" id="input-interval"
                    placeholder="VD: 60" min="1">

                <div class="expires-row">
                    <label>Thời hạn</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="expires_type_interval"
                                value="forever" checked onchange="toggleExpires('interval', this.value)">
                            Vĩnh viễn
                        </label>
                        <label>
                            <input type="radio" name="expires_type_interval"
                                value="limited" onchange="toggleExpires('interval', this.value)">
                            Có hạn
                        </label>
                    </div>
                    <input type="datetime-local" name="expires_at" id="expires-interval"
                        style="display:none; margin-top:6px;">
                </div>
            </div>

            {{-- CHẾ ĐỘ 2: DAILY TIMES --}}
            <div class="mode-section" id="section-daily" style="display:none">
                <label>Giờ chạy trong ngày</label>

                <div class="times-wrap" id="times-tags"></div>
                <input type="hidden" name="daily_times" id="input-daily-times">

                <div class="add-time-row">
                    <input type="time" id="time-picker">
                    <button type="button" class="btn-add-time" onclick="addTime()">+ Thêm</button>
                </div>

                <div class="expires-row">
                    <label>Thời hạn</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="expires_type_daily"
                                value="forever" checked onchange="toggleExpires('daily', this.value)">
                            Vĩnh viễn
                        </label>
                        <label>
                            <input type="radio" name="expires_type_daily"
                                value="limited" onchange="toggleExpires('daily', this.value)">
                            Có hạn
                        </label>
                    </div>
                    <input type="datetime-local" name="expires_at" id="expires-daily"
                        style="display:none; margin-top:6px;">
                </div>
            </div>

            {{-- CHẾ ĐỘ 3: ONCE --}}
            <div class="mode-section" id="section-once" style="display:none">
                <label>Ngày giờ chạy</label>
                <input type="datetime-local" name="run_at" id="input-run-at">
                <div style="font-size:11px; color:#aaa; margin-top:4px;">
                    Chạy đúng 1 lần vào thời điểm này rồi tự kết thúc.
                </div>
            </div>

            <button type="submit" class="btn-submit" id="btn-submit">Thêm nguồn</button>
            <button type="button" class="btn-cancel" id="btn-cancel"
                style="display:none" onclick="resetForm()">Hủy</button>
        </form>
    </div>

    {{-- ========================
         TABLE
    ======================== --}}
    <div class="crawl-table-box">
        <table>
            <thead>
                <tr>
                    <th>Tên nguồn</th>
                    <th>URL</th>
                    <th>Chế độ</th>
                    <th>Max</th>
                    <th>Trạng thái</th>
                    <th>Chạy lần cuối</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sources as $source)
                <tr>
                    <td>{{ $source->name }}</td>

                    <td class="url-cell" title="{{ $source->url }}">{{ $source->url }}</td>

                    <td>
                        @if($source->mode === 'interval')
                            <span class="mode-badge">🔁 Mỗi {{ $source->interval_minutes }} phút</span>
                        @elseif($source->mode === 'daily_times')
                            <span class="mode-badge">🕐 Hàng ngày</span>
                            <div class="schedule-detail">{{ $source->daily_times }}</div>
                        @else
                            <span class="mode-badge">📅 1 lần</span>
                            <div class="schedule-detail">
                                {{ $source->run_at ? $source->run_at->format('d/m/Y H:i') : '' }}
                            </div>
                        @endif

                        @if($source->expires_at)
                            <div class="schedule-detail">
                                Hết hạn: {{ $source->expires_at->format('d/m/Y H:i') }}
                            </div>
                        @endif
                    </td>

                    <td>{{ $source->max_posts }} bài</td>

                    <td>
                        @if($source->is_done)
                            <span class="badge badge-done">Done</span>
                        @elseif($source->expires_at && now()->isAfter($source->expires_at))
                            <span class="badge badge-exp">Hết hạn</span>
                        @elseif($source->is_active)
                            <span class="badge badge-on">Active</span>
                        @else
                            <span class="badge badge-off">Off</span>
                        @endif
                    </td>

                    <td class="last-run">
                        {{ $source->last_run_at ? $source->last_run_at->format('d/m/Y H:i') : 'Chưa chạy' }}
                    </td>

                    <td>
                        <div class="action-btns">

                            <button class="btn-edit" onclick="fillForm({{ $source->id }}, {!! json_encode([
                                'name'             => $source->name,
                                'url'              => $source->url,
                                'mode'             => $source->mode,
                                'max_posts'        => $source->max_posts,
                                'interval_minutes' => $source->interval_minutes,
                                'daily_times'      => $source->daily_times,
                                'run_at'           => $source->run_at?->format('Y-m-d\TH:i'),
                                'expires_at'       => $source->expires_at?->format('Y-m-d\TH:i'),
                            ]) !!})">Edit</button>

                            <form action="/crawl-sources/{{ $source->id }}/toggle" method="POST">
                                @csrf
                                <button type="submit"
                                    class="{{ $source->is_active ? 'btn-toggle-on' : 'btn-toggle-off' }}">
                                    {{ $source->is_active ? 'Tắt' : 'Bật' }}
                                </button>
                            </form>

                            <form action="/crawl-sources/{{ $source->id }}" method="POST"
                                onsubmit="return confirm('Xóa nguồn này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Xóa</button>
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; color:#aaa; padding:30px;">
                        Chưa có nguồn nào. Thêm nguồn đầu tiên bên trái nhé!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection

@section('script')
<script>

    // Danh sách giờ đang chọn (chế độ 2)
    let selectedTimes = [];

    // ========================
    // ĐỔI CHẾ ĐỘ
    // ========================
    function switchMode(mode) {
        document.getElementById('section-interval').style.display = mode === 'interval'    ? 'block' : 'none';
        document.getElementById('section-daily').style.display    = mode === 'daily_times' ? 'block' : 'none';
        document.getElementById('section-once').style.display     = mode === 'once'        ? 'block' : 'none';
    }

    // ========================
    // EXPIRES TOGGLE
    // ========================
    function toggleExpires(type, value) {
        const id = type === 'interval' ? 'expires-interval' : 'expires-daily';
        document.getElementById(id).style.display = value === 'limited' ? 'block' : 'none';
    }

    // ========================
    // THÊM GIỜ (chế độ 2)
    // ========================
    function addTime() {
        const picker = document.getElementById('time-picker');
        const val    = picker.value;

        if (!val) return;
        if (selectedTimes.includes(val)) return;

        selectedTimes.push(val);
        selectedTimes.sort();
        renderTags();
        picker.value = '';
    }

    function removeTime(t) {
        selectedTimes = selectedTimes.filter(x => x !== t);
        renderTags();
    }

    function renderTags() {
        const wrap = document.getElementById('times-tags');
        wrap.innerHTML = selectedTimes.map(t =>
            `<div class="time-tag">${t} <button type="button" onclick="removeTime('${t}')">✕</button></div>`
        ).join('');
        document.getElementById('input-daily-times').value = selectedTimes.join(',');
    }

    // ========================
    // FILL FORM KHI EDIT
    // ========================
    function fillForm(id, data) {
        document.getElementById('form-title').innerText          = '✏️ Sửa nguồn';
        document.getElementById('form-method').value             = 'PUT';
        document.getElementById('input-name').value              = data.name;
        document.getElementById('input-url').value               = data.url;
        document.getElementById('input-max').value               = data.max_posts;
        document.getElementById('input-mode').value              = data.mode;
        document.getElementById('btn-submit').innerText          = 'Cập nhật';
        document.getElementById('btn-cancel').style.display      = 'block';
        document.getElementById('crawl-form').action             = '/crawl-sources/' + id;

        switchMode(data.mode);

        if (data.mode === 'interval') {
            document.getElementById('input-interval').value = data.interval_minutes || '';
        }

        if (data.mode === 'daily_times') {
            selectedTimes = data.daily_times ? data.daily_times.split(',') : [];
            renderTags();
        }

        if (data.mode === 'once') {
            document.getElementById('input-run-at').value = data.run_at || '';
        }

        // expires
        if (data.expires_at) {
            if (data.mode === 'interval') {
                document.querySelector('input[name="expires_type_interval"][value="limited"]').checked = true;
                document.getElementById('expires-interval').style.display = 'block';
                document.getElementById('expires-interval').value = data.expires_at;
            }
            if (data.mode === 'daily_times') {
                document.querySelector('input[name="expires_type_daily"][value="limited"]').checked = true;
                document.getElementById('expires-daily').style.display = 'block';
                document.getElementById('expires-daily').value = data.expires_at;
            }
        }

        document.getElementById('crawl-form').scrollIntoView({ behavior: 'smooth' });
    }

    // ========================
    // RESET FORM
    // ========================
    function resetForm() {
        document.getElementById('form-title').innerText          = '➕ Thêm nguồn mới';
        document.getElementById('form-method').value             = 'POST';
        document.getElementById('input-name').value              = '';
        document.getElementById('input-url').value               = '';
        document.getElementById('input-max').value               = '5';
        document.getElementById('input-mode').value              = 'interval';
        document.getElementById('btn-submit').innerText          = 'Thêm nguồn';
        document.getElementById('btn-cancel').style.display      = 'none';
        document.getElementById('crawl-form').action             = '/crawl-sources';
        selectedTimes = [];
        renderTags();
        switchMode('interval');
    }

    // Init
    switchMode('interval');
</script>
@endsection