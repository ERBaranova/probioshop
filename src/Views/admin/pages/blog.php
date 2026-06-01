<?php
/**
 * Админка: список статей блога
 * Переменные: $articles, $categories
 */
?>
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
  <h2 style="font-size:1.1rem;font-weight:700">Статьи блога</h2>
  <a href="/admin/blog/create" class="btn btn-primary">+ Новая статья</a>
</div>

<?php if ($msg = flashGet('success')): ?>
  <div class="alert alert-success"><?= e($msg) ?></div>
<?php endif; ?>
<?php if ($msg = flashGet('error')): ?>
  <div class="alert alert-error"><?= e($msg) ?></div>
<?php endif; ?>

<div class="admin-card">
  <?php if (empty($articles)): ?>
    <div style="padding:40px;text-align:center;color:var(--muted)">
      Статей пока нет. <a href="/admin/blog/create">Создать первую</a>
    </div>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>Заголовок</th>
          <th>Категория</th>
          <th>Дата</th>
          <th>Статус</th>
          <th>Действия</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($articles as $article): ?>
          <tr>
            <td>
              <a href="/blog/<?= e($article['slug']) ?>" target="_blank" style="font-weight:600;color:var(--text);text-decoration:none">
                <?= e($article['title']) ?>
              </a>
              <div style="font-size:.75rem;color:var(--muted);margin-top:2px">/blog/<?= e($article['slug']) ?></div>
            </td>
            <td><?= e(($categories ?? [])[$article['category']] ?? $article['category']) ?></td>
            <td style="white-space:nowrap"><?= e($article['published_at']) ?></td>
            <td>
              <form method="POST" action="/admin/blog/toggle/<?= e($article['slug']) ?>">
                <button type="submit" class="status-badge <?= $article['published'] ? 'status-done' : 'status-processing' ?>"
                        style="cursor:pointer;border:none;font-family:inherit">
                  <?= $article['published'] ? '✓ Опубликована' : '⏸ Черновик' ?>
                </button>
              </form>
            </td>
            <td>
              <div style="display:flex;gap:6px">
                <a href="/admin/blog/edit/<?= e($article['slug']) ?>" class="btn btn-outline btn-sm">Редактировать</a>
                <form method="POST" action="/admin/blog/delete/<?= e($article['slug']) ?>"
                      onsubmit="return confirm('Удалить статью?')">
                  <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
