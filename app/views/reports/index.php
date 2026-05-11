<div class="card">
    <div class="card-header">
        <div>
            <div class="card-eyebrow">Business Intelligence</div>
            <h3>Laporan ToySight</h3>
        </div>
    </div>

    <form method="GET" action="<?= base_url() ?>/index.php" class="report-form">
        <input type="hidden" name="r" value="reports">
        <div class="report-types">
            <?php
            $types = [
                'sales_summary'        => ['Ringkasan Penjualan', 'Rincian pendapatan & laba bulanan', 'M3 17l6-6 4 4 8-8M14 7h7v7'],
                'product_performance'  => ['Performa Produk', 'Kontributor pendapatan tertinggi & analisis margin', 'M21 16V8L12 3 3 8v8l9 5 9-5z'],
                'store_ranking'        => ['Peringkat Toko', 'Performa berdasarkan lokasi & kota', 'M3 9l1-6h16l1 6M3 9v11h18V9'],
                'category_sales'       => ['Penjualan Kategori', 'Pendapatan & unit berdasarkan kategori produk', 'M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2'],
            ];
            foreach ($types as $k => $info): ?>
            <label class="rt-card <?= $report_type === $k ? 'active' : '' ?>">
                <input type="radio" name="type" value="<?= e($k) ?>" <?= $report_type === $k ? 'checked' : '' ?> onchange="this.form.submit()">
                <span class="rt-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="<?= $info[2] ?>"/></svg></span>
                <span class="rt-title"><?= e($info[0]) ?></span>
                <span class="rt-desc"><?= e($info[1]) ?></span>
            </label>
            <?php endforeach; ?>
        </div>

        <div class="report-filter">
            <div class="filter-group">
                <label>Dari</label>
                <input type="date" name="start_date" value="<?= e($start_date) ?>" min="<?= e($bounds['min_date']) ?>" max="<?= e($bounds['max_date']) ?>">
            </div>
            <div class="filter-group">
                <label>Sampai</label>
                <input type="date" name="end_date" value="<?= e($end_date) ?>" min="<?= e($bounds['min_date']) ?>" max="<?= e($bounds['max_date']) ?>">
            </div>
            <button type="submit" class="btn btn-primary">Buat Laporan</button>
        </div>
    </form>
</div>

<div class="kpi-grid">
    <div class="kpi-card kpi-cyan">
        <div class="kpi-top"><span class="kpi-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 1v22"/></svg></span></div>
        <div class="kpi-value"><?= compact_money((float)$kpis['total_revenue']) ?></div>
        <div class="kpi-label">Pendapatan</div>
    </div>
    <div class="kpi-card kpi-orange">
        <div class="kpi-top"><span class="kpi-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3h2l3 12h13l3-9H6"/></svg></span></div>
        <div class="kpi-value"><?= compact_number((int)$kpis['total_orders']) ?></div>
        <div class="kpi-label">Pesanan</div>
    </div>
    <div class="kpi-card kpi-blue">
        <div class="kpi-top"><span class="kpi-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8L12 3 3 8v8l9 5 9-5z"/></svg></span></div>
        <div class="kpi-value"><?= compact_number((int)$kpis['total_units']) ?></div>
        <div class="kpi-label">Unit Terjual</div>
    </div>
    <div class="kpi-card kpi-green">
        <div class="kpi-top"><span class="kpi-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 17l6-6 4 4 8-8"/></svg></span></div>
        <div class="kpi-value"><?= compact_money((float)$kpis['total_profit']) ?></div>
        <div class="kpi-label">Laba Kotor</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div>
            <div class="card-eyebrow"><?= e(date('M d, Y', strtotime($start_date))) ?> &mdash; <?= e(date('M d, Y', strtotime($end_date))) ?></div>
            <h3><?= e($types[$report_type][0] ?? 'Laporan') ?></h3>
        </div>
        <?php if (Auth::can('reports.export')): ?>
        <div class="report-actions">
            <a class="btn btn-light" href="<?= url('reports/export') ?>&type=<?= e($report_type) ?>&start_date=<?= e($start_date) ?>&end_date=<?= e($end_date) ?>">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Export CSV
            </a>
            <a class="btn btn-light" href="<?= url('reports/print') ?>&type=<?= e($report_type) ?>&start_date=<?= e($start_date) ?>&end_date=<?= e($end_date) ?>" target="_blank">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Cetak / PDF
            </a>
        </div>
        <?php endif; ?>
    </div>

    <div class="table-wrap">
        <table class="table table-clean">
        <?php if ($report_type === 'sales_summary'): ?>
            <thead><tr><th>#</th><th>Periode</th><th class="num">Pendapatan</th><th class="num">Laba</th><th class="num">Pesanan</th></tr></thead>
            <tbody>
            <?php foreach ($data as $i => $r): ?>
            <tr>
                <td><?= ((int)$i) + 1 ?></td>
                <td><strong><?= e($r['label']) ?></strong></td>
                <td class="num"><?= money((float)$r['revenue']) ?></td>
                <td class="num"><?= money((float)$r['profit']) ?></td>
                <td class="num"><?= compact_number((int)$r['orders']) ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        <?php elseif ($report_type === 'product_performance'): ?>
            <thead><tr><th>#</th><th>Produk</th><th>Kategori</th><th>Tier</th><th class="num">Unit</th><th class="num">Pendapatan</th><th class="num">Laba</th><th class="num">Margin %</th></tr></thead>
            <tbody>
            <?php foreach ($data as $i => $r): ?>
            <tr>
                <td><?= ((int)$i) + 1 ?></td>
                <td><strong><?= e($r['product_name']) ?></strong></td>
                <td><?= e($r['product_category']) ?></td>
                <td><span class="chip chip-soft"><?= e($r['price_tier']) ?></span></td>
                <td class="num"><?= compact_number((int)$r['units']) ?></td>
                <td class="num"><strong><?= money((float)$r['revenue']) ?></strong></td>
                <td class="num"><?= money((float)$r['profit']) ?></td>
                <td class="num"><?= number_format((float)$r['margin_pct'], 1) ?>%</td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        <?php elseif ($report_type === 'store_ranking'): ?>
            <thead><tr><th>#</th><th>Toko</th><th>Kota</th><th>Lokasi</th><th class="num">Pesanan</th><th class="num">Unit</th><th class="num">Pendapatan</th><th class="num">Laba</th></tr></thead>
            <tbody>
            <?php foreach ($data as $i => $r): ?>
            <tr>
                <td><?= ((int)$i) + 1 ?></td>
                <td><strong><?= e($r['store_name']) ?></strong></td>
                <td><?= e($r['store_city']) ?></td>
                <td><span class="chip chip-soft"><?= e($r['store_location']) ?></span></td>
                <td class="num"><?= compact_number((int)$r['orders']) ?></td>
                <td class="num"><?= compact_number((int)$r['units']) ?></td>
                <td class="num"><strong><?= money((float)$r['revenue']) ?></strong></td>
                <td class="num"><?= money((float)$r['profit']) ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        <?php elseif ($report_type === 'category_sales'): ?>
            <thead><tr><th>#</th><th>Kategori</th><th class="num">Produk</th><th class="num">Unit</th><th class="num">Pendapatan</th><th class="num">Laba</th></tr></thead>
            <tbody>
            <?php foreach ($data as $i => $r): ?>
            <tr>
                <td><?= ((int)$i) + 1 ?></td>
                <td><strong><?= e($r['category']) ?></strong></td>
                <td class="num"><?= e((string)$r['products']) ?></td>
                <td class="num"><?= compact_number((int)$r['units']) ?></td>
                <td class="num"><strong><?= money((float)$r['revenue']) ?></strong></td>
                <td class="num"><?= money((float)$r['profit']) ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        <?php endif; ?>
        </table>
    </div>
</div>