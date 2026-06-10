<section class="section section--soft" id="faq">
    <div class="container">
        <div class="section__header section__header--center">
            <div class="section__label">FAQ</div>
            <h2 class="section__title">Часто задаваемые вопросы</h2>
        </div>

        <div style="max-width:760px;margin:0 auto">
            <?php foreach ([
                ['Заказ и оплата', [
                    ['Как сделать заказ?',
                     'Всё просто: добавляйте товары в корзину прямо на сайте и оформляйте заказ в пару кликов. Понадобится помощь — напишите нам, разберёмся вместе.'],
                    ['Какие способы оплаты?',
                     'Удобно для вас — удобно для нас. Оплачивайте наличными или картой курьеру при получении, либо наложенным платежом при доставке Почтой России.'],
                ]],
                ['Доставка', [
                    ['Сколько стоит доставка?',
                     'Отправляем курьером, СДЭК и Почтой России — по всей стране. Точную стоимость увидите при оформлении заказа: она считается автоматически по вашему адресу и весу.'],
                    ['Есть ли самовывоз?',
                     'Пока нет, но мы доберёмся до вас сами — выбирайте удобный способ доставки при оформлении.'],
                ]],
                ['Товар', [
                    ['Безопасно ли для детей и животных?',
                     'Абсолютно. Никакой агрессивной химии — только пробиотические культуры. Можно убирать без перчаток, не переживать за кошку на подоконнике и ребёнка на полу. Сертифицировано даже для медицинских учреждений.'],
                    ['Как правильно разводить концентрат?',
                     'Сначала встряхните флакон — это важно! Затем добавьте средство в тёплую воду (не горячее 60°C).<br><br>
                      Дозировка зависит от загрязнения:<br>
                      · первичная уборка распылителем — 50–100 мл на 1 л воды<br>
                      · повторная уборка распылителем — постепенно уменьшайте до 0,5 мл на 1 л<br>
                      · первичная влажная уборка (ведро 8 л) — начинайте с 20 мл<br><br>
                      Встряхните раствор, дайте поработать 20–30 минут, встряхните ещё раз — и убирайте как обычно. Пробиотики продолжат работать ещё до 3 суток после нанесения.'],
                ]],
            ] as [$group, $items]): ?>

                <div style="margin-bottom:8px;margin-top:24px">
                    <div class="section__label"><?= $group ?></div>
                </div>

                <?php foreach ($items as $idx => [$q, $a]):
                    $uid = md5($q); ?>
                    <div style="border-bottom:1px solid var(--border)">
                        <button onclick="toggleFaq('<?= $uid ?>')"
                                style="width:100%;text-align:left;background:none;border:none;padding:16px 0;cursor:pointer;display:flex;justify-content:space-between;align-items:center;gap:16px">
                            <span style="font-size:.95rem;font-weight:700;color:var(--green-dark)"><?= e($q) ?></span>
                            <span id="icon-<?= $uid ?>" style="font-size:1.2rem;color:var(--green);flex-shrink:0;transition:transform .2s">+</span>
                        </button>
                        <div id="faq-<?= $uid ?>" style="display:none;padding-bottom:16px">
                            <p style="font-size:.9rem;color:var(--muted);line-height:1.75"><?= $a ?></p>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endforeach ?>
        </div>
    </div>
</section>

<script>
function toggleFaq(id) {
    const body = document.getElementById('faq-' + id);
    const icon = document.getElementById('icon-' + id);
    const open = body.style.display === 'none';
    body.style.display = open ? 'block' : 'none';
    icon.style.transform = open ? 'rotate(45deg)' : '';
}
</script>
