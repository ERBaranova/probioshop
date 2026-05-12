<meta name="csrf" content="<?= csrfToken() ?>">

<!-- Хлебные крошки -->
<div class="container" style="padding-top:16px">
    <nav class="breadcrumb">
        <a href="/">Главная</a><span>→</span><span>Для бизнеса</span>
    </nav>
</div>

<!-- HERO -->
<section class="hero" style="padding:48px 0 36px">
    <div class="container">
        <div class="hero__eyebrow">Chrisal B2B · Официальный дистрибьютор в России</div>
        <h1 class="hero__title" style="font-size:2.2rem">
            Пробиотики для бизнеса —<br><em>экономия 60–80% на клининге</em>
        </h1>
        <p class="hero__sub" style="max-width:560px">
            Профессиональные концентраты для ресторанов, медучреждений, отелей, ферм
            и клининговых компаний. Сотрудники работают без перчаток и масок.
        </p>
        <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:28px">
            <a href="#form" class="btn btn--primary btn--lg">Запросить КП →</a>
            <a href="/catalog?audience=business" class="btn btn--ghost btn--lg">Смотреть каталог</a>
        </div>
        <!-- Trust bar — релевантные для РФ B2B -->
        <div class="trust-bar">
            <div class="trust-item"><div class="trust-check">✓</div> Сертификат для хирургических кабинетов</div>
            <div class="trust-item"><div class="trust-check">✓</div> ХАССП-совместимо</div>
            <div class="trust-item"><div class="trust-check">✓</div> Валидировано Гентским университетом</div>
            <div class="trust-item"><div class="trust-check">✓</div> Сертификат Роспотребнадзора</div>
        </div>
    </div>
</section>

<!-- ЦИФРЫ -->
<section style="background:var(--white);border-bottom:1px solid var(--border);padding:28px 0">
    <div class="container">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:1px;background:var(--border);border-radius:var(--radius-lg);overflow:hidden">
            <?php foreach ([
                ['−70%',    'средняя экономия на моющих средствах'],
                ['72 часа', 'активность пробиотиков после уборки'],
                ['0',       'СИЗ — перчаток и масок не нужно'],
                ['1:100',   'разведение концентрата'],
                ['28 дней', 'полное биоразложение состава'],
                ['30+',     'стран используют Chrisal'],
            ] as [$num, $label]): ?>
                <div style="background:var(--white);padding:20px 24px;text-align:center">
                    <div style="font-size:1.6rem;font-weight:900;color:var(--green-dark)"><?= $num ?></div>
                    <div style="font-size:.78rem;color:var(--muted);margin-top:4px;line-height:1.4"><?= $label ?></div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</section>

<!-- ОСНОВНОЙ КОНТЕНТ -->
<div class="container" style="padding-top:40px;padding-bottom:64px">
    <div style="display:grid;grid-template-columns:1fr 380px;gap:40px;align-items:start">

        <!-- ЛЕВАЯ КОЛОНКА -->
        <div>

            <!-- Ниши -->
            <div class="section__label" style="margin-bottom:8px">Кому подходит</div>
            <h2 style="font-size:1.4rem;font-weight:800;color:var(--green-dark);margin-bottom:6px">Одно средство — для всего объекта</h2>
            <p style="color:var(--muted);font-size:.9rem;margin-bottom:20px">Не нужно держать 10 разных чистящих средств под каждую поверхность</p>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:36px">
                <?php foreach ([
                    ['🏥', 'Медучреждения',          'Больницы, клиники, стоматологии, ветклиники. Сертификат до операционной.'],
                    ['🍽️', 'Рестораны и HoReCa',    'Кухни, залы, оборудование. ХАССП и проверки Роспотребнадзора — без проблем.'],
                    ['🏨', 'Отели и санатории',       'Номера, холлы, бассейны, спа. Один поставщик для всего объекта.'],
                    ['🧹', 'Клининговые компании',    'Снижение расхода средств, безопасность персонала без СИЗ.'],
                    ['🐄', 'Агробизнес и фермы',      'КРС, птицеводство, ветеринария. Отдельная линейка для животных.'],
                    ['🏭', 'Производства',             'Пищевые, фармацевтические, промышленные объекты.'],
                ] as [$icon, $title, $desc]): ?>
                    <div class="why-card" style="padding:16px">
                        <div style="font-size:1.6rem;margin-bottom:8px"><?= $icon ?></div>
                        <h3 style="font-size:.88rem;font-weight:800;color:var(--green-dark);margin-bottom:4px"><?= $title ?></h3>
                        <p style="font-size:.78rem;color:var(--muted2);line-height:1.5"><?= $desc ?></p>
                    </div>
                <?php endforeach ?>
            </div>

            <!-- Преимущества для бизнеса -->
            <div class="section__label" style="margin-bottom:8px">Экономика</div>
            <h2 style="font-size:1.4rem;font-weight:800;color:var(--green-dark);margin-bottom:20px">Почему бизнес переходит на Chrisal</h2>

            <?php foreach ([
                ['💰', 'Экономия на расходниках',
                    'Концентрат 1:100 — один литр даёт 100 литров готового средства. Итого: средняя экономия 60–80% по сравнению с обычной бытхимией при одинаковом объёме уборки.'],
                ['🦺', 'Снижение затрат на СИЗ',
                    'Персонал работает без перчаток, масок и спецодежды. Для клининговых компаний это несколько тысяч рублей экономии в месяц на каждого сотрудника.'],
                ['📋', 'Прохождение проверок',
                    'ХАССП-совместимость, сертификация для медучреждений, биоразлагаемый состав — Роспотребнадзор, Россельхознадзор и санэпидемслужба вопросов не задают.'],
                ['⏱️', 'Реже убираться — тот же результат',
                    'Пробиотики продолжают работать 72 часа после нанесения. На практике: уборку в санузлах можно делать реже без потери санитарного результата.'],
            ] as [$icon, $title, $text]): ?>
                <div style="display:flex;gap:16px;margin-bottom:20px;align-items:start">
                    <div style="font-size:1.5rem;flex-shrink:0;width:40px;text-align:center"><?= $icon ?></div>
                    <div>
                        <h3 style="font-size:.9rem;font-weight:800;color:var(--green-dark);margin-bottom:4px"><?= $title ?></h3>
                        <p style="font-size:.85rem;color:var(--muted);line-height:1.65"><?= $text ?></p>
                    </div>
                </div>
            <?php endforeach ?>

            <!-- Кейсы -->
            <div style="margin-top:36px">
                <div class="section__label" style="margin-bottom:8px">Отзывы клиентов</div>
                <h2 style="font-size:1.4rem;font-weight:800;color:var(--green-dark);margin-bottom:20px">Что говорят руководители</h2>

                <?php foreach ([
                    ['Управляющий сетью ресторанов', 'Москва',
                     'Перешли на Chrisal 8 месяцев назад. Расходы на бытхимию упали в 3 раза, а проверки Роспотребнадзора проходим без замечаний. Плюс повара перестали жаловаться на запах от хлорки на кухне.'],
                    ['Главный врач клиники', 'Санкт-Петербург',
                     'Единственное средство с сертификатом для операционной, которое персонал использует без СИЗ. Экономия на закупке перчаток и масок полностью покрыла разницу в цене.'],
                    ['Директор птицефермы', 'Краснодарский край',
                     'Запах в птичниках снизился в разы. Пробиотики продолжают работать в подстилке между обработками — не нужна ежедневная обработка всего помещения.'],
                ] as [$who, $city, $text]): ?>
                    <div style="border-left:3px solid var(--green-border);padding:14px 0 14px 18px;margin-bottom:16px">
                        <div style="font-size:.78rem;font-weight:700;color:var(--green);margin-bottom:6px">
                            <?= $who ?> · <?= $city ?>
                        </div>
                        <p style="font-size:.88rem;color:var(--muted);line-height:1.7;font-style:italic">«<?= $text ?>»</p>
                    </div>
                <?php endforeach ?>
            </div>

            <!-- Сертификаты -->
            <div style="margin-top:36px;background:var(--green-pale);border-radius:var(--radius-lg);padding:24px">
                <div class="section__label" style="margin-bottom:8px">Сертификация</div>
                <h2 style="font-size:1.2rem;font-weight:800;color:var(--green-dark);margin-bottom:16px">Кто проверил и подтвердил</h2>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                    <?php foreach ([
                        ['🏛️', 'Гентский университет',   'Биоразлагаемость, безопасность'],
                        ['🇧🇪', 'CEBETOX, Бельгия',      'Нетоксичность при пероральном воздействии'],
                        ['🏥', 'Dr. W.U. Fäber Institut','Инфекционный контроль в больницах'],
                        ['🌾', 'USDA, Вашингтон',        'Пищевая промышленность, ХАССП'],
                        ['✈️', 'Boeing & Douglas',        'Очистка воздушных судов'],
                        ['📋', 'ISO 9001:2008',           'Система менеджмента качества'],
                    ] as [$icon, $title, $desc]): ?>
                        <div style="display:flex;align-items:flex-start;gap:10px">
                            <span style="font-size:1.2rem;flex-shrink:0"><?= $icon ?></span>
                            <div>
                                <div style="font-size:.82rem;font-weight:700;color:var(--green-dark)"><?= $title ?></div>
                                <div style="font-size:.75rem;color:var(--muted2)"><?= $desc ?></div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>

        </div>

        <!-- ПРАВАЯ КОЛОНКА — ФОРМА (sticky) -->
        <div style="position:sticky;top:80px" id="form">

            <?php if ($success): ?>
                <div style="background:var(--green-light);border:1.5px solid var(--green-border);border-radius:var(--radius-lg);padding:28px;text-align:center">
                    <div style="font-size:3rem;margin-bottom:12px">✅</div>
                    <h3 style="font-weight:800;color:var(--green-dark);margin-bottom:8px">Заявка принята!</h3>
                    <p style="font-size:.9rem;color:var(--muted);line-height:1.6"><?= e($success) ?></p>
                    <a href="/b2b" class="btn btn--outline" style="margin-top:16px">Отправить ещё одну</a>
                </div>
            <?php else: ?>

            <div style="background:var(--white);border:1.5px solid var(--border);border-radius:var(--radius-lg);padding:24px;box-shadow:var(--shadow)">
                <h2 style="font-size:1.1rem;font-weight:800;color:var(--green-dark);margin-bottom:4px">
                    Запросить коммерческое предложение
                </h2>
                <p style="font-size:.82rem;color:var(--muted);margin-bottom:18px">
                    Ответим в течение рабочего дня с расчётом под ваш объект
                </p>

                <?php if ($error): ?>
                    <div class="alert alert--error"><?= e($error) ?></div>
                <?php endif ?>

                <form method="POST" action="/b2b">
                    <input type="hidden" name="_csrf" value="<?= csrfToken() ?>">

                    <div class="form-group">
                        <label class="form-label">Компания *</label>
                        <input type="text" name="company" class="form-input" required
                               placeholder="ООО «Название»">
                    </div>

                    <div class="form-row">
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">Ваше имя *</label>
                            <input type="text" name="name" class="form-input" required placeholder="Имя">
                        </div>
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">Телефон *</label>
                            <input type="tel" name="phone" class="form-input" required
                                   placeholder="+7 (___) ___-__-__">
                        </div>
                    </div>
                    <div style="height:14px"></div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input" placeholder="mail@company.ru">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Тип объекта</label>
                        <select name="object_type" class="form-input">
                            <option value="">Выберите...</option>
                            <?php foreach ($objectTypes as $key => $label): ?>
                                <option value="<?= e($key) ?>"><?= e($label) ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Что интересует</label>
                        <div style="display:flex;flex-direction:column;gap:7px;margin-top:4px">
                            <?php foreach ($interests as $key => $label): ?>
                                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:.85rem;color:var(--muted)">
                                    <input type="checkbox" name="interest_<?= e($key) ?>"
                                           style="accent-color:var(--green)">
                                    <?= e($label) ?>
                                </label>
                            <?php endforeach ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Примерный объём в месяц</label>
                        <select name="volume" class="form-input">
                            <?php foreach ($volumeOptions as $key => $label): ?>
                                <option value="<?= e($key) ?>"><?= e($label) ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Комментарий</label>
                        <textarea name="comment" class="form-input" rows="3"
                                  placeholder="Специфика объекта, текущие средства, срочность..."></textarea>
                    </div>

                    <button type="submit" class="btn btn--primary btn--full" style="padding:13px;font-size:.95rem">
                        Отправить заявку →
                    </button>
                    <p style="font-size:.72rem;color:var(--muted2);text-align:center;margin-top:8px">
                        Без спама. Ответим персонально с расчётом под ваш объём.
                    </p>
                </form>

                <!-- Сценарий -->
                <div style="margin-top:18px;border-top:1px solid var(--border);padding-top:14px">
                    <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--muted2);margin-bottom:10px">Что будет дальше</div>
                    <?php foreach ([
                        ['1', 'Менеджер позвонит в течение рабочего дня'],
                        ['2', 'Подберём состав под ваш объект и задачи'],
                        ['3', 'Пришлём КП с ценами, расходом и экономией'],
                        ['4', 'Тестовая партия — по запросу бесплатно'],
                    ] as [$n, $text]): ?>
                        <div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid var(--border)">
                            <div style="width:22px;height:22px;background:var(--green-light);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:800;color:var(--green-dark);flex-shrink:0">
                                <?= $n ?>
                            </div>
                            <span style="font-size:.82rem;color:var(--muted)"><?= $text ?></span>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>

            <?php endif ?>
        </div>

    </div>
</div>

<!-- CTA внизу страницы -->
<section style="background:var(--green-dark);padding:48px 0">
    <div class="container" style="text-align:center">
        <h2 style="font-size:1.6rem;font-weight:900;color:#fff;margin-bottom:12px">
            Готовы обсудить сотрудничество?
        </h2>
        <p style="color:rgba(255,255,255,.75);margin-bottom:24px;font-size:.95rem">
            Рассчитаем экономию конкретно для вашего объекта
        </p>
        <a href="#form" class="btn btn--primary" style="background:#fff;color:var(--green-dark);padding:13px 32px;font-size:1rem">
            Запросить КП →
        </a>
    </div>
</section>
