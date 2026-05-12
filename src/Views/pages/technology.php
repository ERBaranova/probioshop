<?php
/**
 * Страница /technology — «Как работают моющие пробиотики»
 *
 * SEO-цели:
 *   H1: «Как работают моющие пробиотики» (info-запрос, конкуренты не закрыли)
 *   H2: подзапросы — биоплёнка, Bacillus, сравнение с химией, сертификаты
 *   FAQ: видимый на странице (обязательно для FAQPage schema)
 *   LSI: биоплёнка, Bacillus subtilis, ПАВ, конкурентное вытеснение,
 *         патогены, энзимы, Гентский университет, ХАССП
 */
?>
<!-- Хлебные крошки — видимые (и в schema) -->
<nav class="container" style="padding-top:20px">
    <div class="breadcrumb">
        <a href="/">Главная</a>
        <span>→</span>
        <span>Технология</span>
    </div>
</nav>

<!-- HERO -->
<section class="hero" style="padding:48px 0 36px">
    <div class="container">
        <div class="hero__eyebrow">Наука · Chrisal · Гентский университет</div>
        <h1 class="hero__title" style="font-size:2.1rem">
            Как работают<br><em>моющие пробиотики</em>
        </h1>
        <p class="hero__sub" style="max-width:600px">
            Обычные средства убивают бактерии — и перестают работать. Пробиотики Chrisal
            продолжают действовать <strong>72 часа после нанесения</strong>, проникают в биоплёнку
            и вытесняют патогены на микробиологическом уровне.
        </p>
        <div style="display:flex;gap:10px;flex-wrap:wrap">
            <a href="/catalog" class="btn btn--primary">Смотреть каталог</a>
            <a href="#faq" class="btn btn--ghost">Частые вопросы ↓</a>
        </div>
    </div>
</section>

<!-- КАК РАБОТАЕТ — 3 шага -->
<section class="section">
    <div class="container">
        <div class="section__header section__header--center">
            <div class="section__label">Механизм</div>
            <h2 class="section__title">3 этапа действия пробиотиков</h2>
            <p class="section__sub">В отличие от химии — работает не разово, а непрерывно</p>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:24px;margin-bottom:0">
            <?php foreach ([
                ['🧼', '1. Моющий компонент', 'Биоразлагаемое вещество физически отделяет загрязнение от поверхности. Без агрессивных ПАВ — не разъедает материал, не оставляет химических соединений.'],
                ['⚡', '2. Ферменты (энзимы)', 'Молниеносно разрезают биоплёнку патогенных бактерий — защитный матрикс, который обычная химия не пробивает. Готовят поверхность для заселения пробиотиками.'],
                ['🦠', '3. Bacillus — живые бактерии', 'Пять штаммов Bacillus (subtilis, amyloliquefaciens, licheniformis, pumilus, megaterium) занимают освободившееся место. Вытесняют патогены методом конкурентного вытеснения и остаются активны до 72 часов.'],
            ] as [$icon, $title, $text]): ?>
                <div class="why-card">
                    <div style="font-size:2rem;margin-bottom:12px"><?= $icon ?></div>
                    <h3 class="why-card__title"><?= $title ?></h3>
                    <p class="why-card__text"><?= $text ?></p>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</section>

<!-- БИОПЛЁНКА — отдельный блок (LSI-слово) -->
<section class="section section--soft">
    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:center">
            <div>
                <div class="section__label">Главная проблема</div>
                <h2 class="section__title">Что такое биоплёнка и почему её не берёт химия</h2>
                <p style="color:var(--muted);line-height:1.8;margin-bottom:16px;font-size:.95rem">
                    Биоплёнка — защитный матрикс из полисахаридов, который патогенные бактерии
                    выстраивают на поверхностях. Она в 500–1000 раз устойчивее к дезинфектантам,
                    чем одиночные бактерии.
                </p>
                <p style="color:var(--muted);line-height:1.8;margin-bottom:20px;font-size:.95rem">
                    Хлор и спиртовые антисептики работают только снаружи матрикса. Внутрь не
                    проникают — высокое поверхностное натяжение воды не пускает. Поэтому после
                    уборки химией патогены возвращаются уже через несколько часов.
                </p>
                <p style="color:var(--muted);line-height:1.8;font-size:.95rem">
                    Ферменты Chrisal расщепляют матрикс биоплёнки. После этого пробиотики
                    Bacillus заселяют поверхность и удерживают её — патогены физически
                    не могут вернуться.
                </p>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                <?php foreach ([
                    ['🧫', 'Bacillus subtilis',           'Универсальный уничтожитель патогенов'],
                    ['🔬', 'Bacillus amyloliquefaciens',  'Расщепляет крахмал и жиры'],
                    ['🧪', 'Bacillus licheniformis',      'Антигрибковый и антиплесневый'],
                    ['💊', 'Bacillus pumilus + megaterium','Широкий антибактериальный спектр'],
                ] as [$icon, $title, $desc]): ?>
                    <div class="why-card" style="padding:16px">
                        <div style="font-size:1.5rem;margin-bottom:8px"><?= $icon ?></div>
                        <div style="font-size:.8rem;font-weight:800;color:var(--green-dark);margin-bottom:3px;line-height:1.3"><?= $title ?></div>
                        <div style="font-size:.75rem;color:var(--muted2)"><?= $desc ?></div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</section>

<!-- СРАВНЕНИЕ -->
<section class="section">
    <div class="container">
        <div class="section__header section__header--center">
            <div class="section__label">Сравнение</div>
            <h2 class="section__title">Пробиотики vs обычная химия</h2>
        </div>
        <div class="compare-wrap" style="background:var(--white);border:1px solid var(--border);border-radius:var(--radius-lg);overflow:hidden">
            <table class="compare-table">
                <thead>
                    <tr>
                        <th style="width:38%">Параметр</th>
                        <th>Хлор / ПАВ / спирт</th>
                        <th>Chrisal (пробиотики)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ([
                        ['Работает после высыхания',            '✗ Перестаёт сразу',             '✓ До 72 часов'],
                        ['Проникает в биоплёнку',               '✗ Только поверхность',          '✓ Полное разрушение матрикса'],
                        ['Устойчивость бактерий (мутации)',     '✗ Растёт с каждым применением', '✓ Конкурентное вытеснение — без мутаций'],
                        ['Безопасно без перчаток',              '✗ Хим. ожоги, пары',            '✓ Голыми руками'],
                        ['Безопасно для детей до 3 лет',        '✗ Запрещено',                   '✓ Сертифицировано'],
                        ['Биоразлагаемость',                    '✗ Накапливается в природе',     '✓ Полное разложение за 28 дней'],
                        ['Один флакон = несколько применений',  '✗ Каждой поверхности своё',     '✓ До 8 применений'],
                    ] as [$param, $bad, $good]): ?>
                        <tr>
                            <td><?= $param ?></td>
                            <td class="no"><?= $bad ?></td>
                            <td class="yes"><?= $good ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- СЕРТИФИКАТЫ -->
<section class="section section--soft">
    <div class="container">
        <div class="section__header section__header--center">
            <div class="section__label">Доверие</div>
            <h2 class="section__title">Кто проверил и подтвердил</h2>
            <p class="section__sub">Chrisal прошёл сертификацию в 12 независимых организациях</p>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px">
            <?php foreach ([
                ['🏛️', 'Гентский университет',    'Биоразлагаемость и безопасность состава'],
                ['🇧🇪', 'CEBETOX, Бельгия',       'Нетоксичность при пероральном воздействии'],
                ['✈️', 'Boeing & Douglas',         'Очистка воздушных судов'],
                ['🪖', 'Армия НАТО',               'Сухопутные войска Бельгии'],
                ['🏥', 'Dr. W.U. Fäber Institut', 'Инфекционный контроль в больницах'],
                ['🌾', 'USDA, Вашингтон',          'Пищевая промышленность, ХАССП'],
            ] as [$icon, $title, $desc]): ?>
                <div class="why-card" style="text-align:center;padding:20px">
                    <div style="font-size:2rem;margin-bottom:10px"><?= $icon ?></div>
                    <div style="font-size:.88rem;font-weight:800;color:var(--green-dark);margin-bottom:4px"><?= $title ?></div>
                    <div style="font-size:.78rem;color:var(--muted2);line-height:1.4"><?= $desc ?></div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</section>

<!-- FAQ — ВИДИМЫЙ на странице (обязательно для FAQPage schema Google) -->
<section class="section" id="faq">
    <div class="container">
        <div class="section__header section__header--center">
            <div class="section__label">FAQ</div>
            <h2 class="section__title">Часто задаваемые вопросы</h2>
        </div>

        <div style="max-width:720px;margin:0 auto" id="faq-list">
            <?php foreach ([
                ['Как работают моющие пробиотики?',
                 'Пробиотики используют метод конкурентного вытеснения: полезные бактерии Bacillus вытесняют патогенные, расщепляют биоплёнку и органику до CO₂ и воды. Остаются активными до 72 часов после нанесения — обычные средства перестают работать сразу.'],
                ['Безопасны ли средства Chrisal для детей и животных?',
                 'Да. Все средства Chrisal не содержат хлора, фосфатов и агрессивных ПАВ. Сертифицированы CEBETOX (Бельгия) как нетоксичные при пероральном воздействии. Можно использовать без перчаток и масок.'],
                ['Чем пробиотики лучше обычных моющих средств?',
                 'Обычные средства работают только в момент уборки. Пробиотики продолжают уничтожать патогены 3 суток после высыхания, проникают в микропоры и разрушают биоплёнку — защитный щит вредных бактерий.'],
                ['Можно ли мыть посуду пробиотическими средствами?',
                 'Да. Средства Chrisal PIP разработаны для мытья посуды и всех поверхностей на кухне. Биоразлагаемый состав безопасен для слива в канализацию.'],
                ['Для каких объектов сертифицированы средства Chrisal?',
                 'Chrisal сертифицирован для медучреждений (включая хирургические кабинеты), пищевой промышленности (ХАССП), авиации (Boeing, Douglas), армии стран НАТО, сельского хозяйства и ветеринарии.'],
                ['Что такое биоплёнка и почему её сложно убрать?',
                 'Биоплёнка — защитный матрикс, который патогенные бактерии создают на поверхностях. Обычные дезинфектанты работают снаружи и не проникают внутрь. Ферменты Chrisal разрушают матрикс, после чего пробиотики вытесняют патогены полностью.'],
            ] as $i => [$q, $a]): ?>
                <div class="faq-item" style="border-bottom:1px solid var(--border);padding:0">
                    <button class="faq-q" onclick="toggleFaq(<?= $i ?>)" aria-expanded="false"
                            style="width:100%;text-align:left;background:none;border:none;padding:18px 0;cursor:pointer;display:flex;justify-content:space-between;align-items:center;gap:16px">
                        <span style="font-size:.95rem;font-weight:700;color:var(--green-dark)"><?= e($q) ?></span>
                        <span class="faq-icon" style="font-size:1.2rem;color:var(--green);flex-shrink:0;transition:transform .2s">+</span>
                    </button>
                    <div class="faq-a" id="faq-a-<?= $i ?>" style="display:none;padding-bottom:18px">
                        <p style="font-size:.9rem;color:var(--muted);line-height:1.75"><?= e($a) ?></p>
                    </div>
                </div>
            <?php endforeach ?>
        </div>

        <div style="text-align:center;margin-top:36px">
            <a href="/catalog" class="btn btn--primary btn--lg">Перейти в каталог →</a>
        </div>
    </div>
</section>

<style>
.faq-q:hover span:first-child { color: var(--green); }
.faq-icon.open { transform: rotate(45deg); }
</style>

<script>
function toggleFaq(i) {
    const a   = document.getElementById('faq-a-' + i);
    const btn = a.previousElementSibling;
    const ico = btn.querySelector('.faq-icon');
    const open = a.style.display === 'none';
    a.style.display = open ? 'block' : 'none';
    ico.classList.toggle('open', open);
    btn.setAttribute('aria-expanded', open);
}
</script>
