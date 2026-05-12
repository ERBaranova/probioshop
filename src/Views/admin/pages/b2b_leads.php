<?php
$statuses = ['' => 'Все', 'new' => 'Новые', 'contacted' => 'Контакт', 'qualified' => 'Квалифицирован', 'closed' => 'Закрыт'];
$interests = B2bLead::interestOptions();
?>
<div style="display:flex;gap:8px;margin-bottom:20px;flex-wrap:wrap">
    <?php foreach ($statuses as $s => $label): ?>
        <a href="/admin/b2b<?= $s ? '?status=' . $s : '' ?>"
           class="btn btn-sm <?= $filterStatus === $s ? 'btn-primary' : 'btn-outline' ?>">
            <?= $label ?>
        </a>
    <?php endforeach ?>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h2>B2B заявки (<?= count($leads) ?>)</h2>
        <a href="/b2b" target="_blank" class="btn btn-outline btn-sm">↗ Открыть B2B-страницу</a>
    </div>

    <?php if (empty($leads)): ?>
        <div style="padding:32px;text-align:center;color:var(--muted)">Заявок ещё нет</div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Компания / Контакт</th>
                    <th>Объект</th>
                    <th>Интересует</th>
                    <th>Объём</th>
                    <th>Статус</th>
                    <th>Дата</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leads as $lead): ?>
                    <tr>
                        <td>
                            <div style="font-weight:600;font-size:.875rem"><?= e($lead['company']) ?></div>
                            <div style="font-size:.78rem;color:var(--muted)"><?= e($lead['name']) ?></div>
                            <div style="font-size:.78rem;color:var(--muted)"><?= e($lead['phone']) ?></div>
                            <?php if (!empty($lead['email'])): ?>
                                <div style="font-size:.75rem;color:var(--muted)"><?= e($lead['email']) ?></div>
                            <?php endif ?>
                        </td>
                        <td style="font-size:.82rem;color:var(--muted)">
                            <?= e(B2bLead::objectTypes()[$lead['object_type']] ?? $lead['object_type'] ?? '—') ?>
                        </td>
                        <td style="font-size:.78rem;color:var(--muted)">
                            <?php foreach ($lead['interests'] ?? [] as $int): ?>
                                <div>· <?= e($interests[$int] ?? $int) ?></div>
                            <?php endforeach ?>
                        </td>
                        <td style="font-size:.78rem;color:var(--muted)">
                            <?= e(B2bLead::volumeOptions()[$lead['volume']] ?? $lead['volume'] ?? '—') ?>
                        </td>
                        <td>
                            <form method="POST" action="/admin/b2b/<?= e($lead['id']) ?>/status">
                                <input type="hidden" name="_csrf" value="<?= csrfToken() ?>">
                                <select name="status" class="form-input" style="font-size:.78rem;padding:4px 8px"
                                        onchange="this.form.submit()">
                                    <?php foreach (['new'=>'Новая','contacted'=>'Контакт','qualified'=>'Квалифицирован','closed'=>'Закрыт'] as $s => $l): ?>
                                        <option value="<?= $s ?>" <?= $lead['status'] === $s ? 'selected' : '' ?>><?= $l ?></option>
                                    <?php endforeach ?>
                                </select>
                            </form>
                        </td>
                        <td style="font-size:.78rem;color:var(--muted);white-space:nowrap">
                            <?= e(substr($lead['created_at'], 0, 10)) ?>
                        </td>
                        <td>
                            <?php if (!empty($lead['comment'])): ?>
                                <span title="<?= e($lead['comment']) ?>" style="cursor:help;color:var(--muted)">💬</span>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>
</div>
