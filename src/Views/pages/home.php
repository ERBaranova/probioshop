<meta name="csrf" content="<?= csrfToken() ?>">

<!-- HERO -->
<section class="hero">
  <div class="container">
    <div class="hero__inner">

      <div>
        <div class="hero__eyebrow">Chrisal · Бельгия · 30+ стран мира</div>
        <h1 class="hero__title">Один флакон —<br><em>вместо восьми средств</em></h1>
        <p class="hero__sub">Пробиотические средства продолжают работать до 3 суток после нанесения. Сертифицированы для хирургических кабинетов. Безопасны для детей, животных и водоёмов.</p>

        <div class="switcher" id="hero-switcher">
          <button class="sw-btn sw-btn--active" data-seg="home">🏠 Для дома</button>
          <button class="sw-btn" data-seg="biz">💼 Для бизнеса</button>
          <button class="sw-btn" data-seg="animals">🐄 Животные</button>
          <button class="sw-btn" data-seg="water">💧 Водоёмы</button>
        </div>

        <div class="scenario-grid" id="scenario-grid"></div>

        <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:28px">
          <a href="/catalog" class="btn btn--primary btn--lg" id="hero-cta">Смотреть товары для дома</a>
          <a href="#calc" class="btn btn--ghost btn--lg">Калькулятор экономии ↓</a>
        </div>

        <div class="trust-bar">
          <div class="trust-item"><div class="trust-check">✓</div> Без хлора и фосфатов</div>
          <div class="trust-item"><div class="trust-check">✓</div> Работает 3 суток</div>
          <div class="trust-item"><div class="trust-check">✓</div> Сертификат для медучреждений</div>
          <div class="trust-item"><div class="trust-check">✓</div> Валидировано Гентским университетом</div>
          <div class="trust-item"><div class="trust-check">✓</div> Можно без перчаток и масок</div>
        </div>
      </div>

      <div class="hero__right" id="calc">
        <div class="calc-card">
          <div class="calc-card__title">🧮 Калькулятор замены</div>
          <div class="calc-card__sub">Выберите что стоит в шкафу — увидите экономию</div>
          <div class="calc-label-row">Что вы обычно покупаете?</div>
          <div class="calc-toggles" id="calc-toggles"></div>
          <div class="calc-results">
            <div class="calc-stat">
              <div class="calc-num" id="r-items">0</div>
              <div class="calc-desc">средств<br>заменяет</div>
            </div>
            <div class="calc-stat">
              <div class="calc-num" id="r-save">0 ₽</div>
              <div class="calc-desc">экономия<br>в год</div>
            </div>
            <div class="calc-stat">
              <div class="calc-num" id="r-plastic">0</div>
              <div class="calc-desc">пластик.<br>флаконов меньше</div>
            </div>
          </div>
          <p style="font-size:.72rem;color:var(--muted2);margin-top:12px;line-height:1.5">
            * Расчёт на 12 месяцев. Стоимость Chrisal — 2 флакона в год (~10 800 ₽), разведение 1:100.
          </p>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- FEATURED PRODUCTS -->
<section class="section">
  <div class="container">
    <div class="section__header" style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:28px">
      <div>
        <div class="section__label">Каталог</div>
        <h2 class="section__title" id="featured-title">Популярные для дома</h2>
        <p class="section__sub">На основе живых пробиотических культур Chrisal</p>
      </div>
      <a href="/catalog" class="btn btn--outline" id="featured-link">Все <?= count($allProducts) ?> товаров →</a>
    </div>
    <div class="product-grid" id="featured-grid"></div>
  </div>
</section>

<!-- WHY TABLE -->
<section class="section section--soft">
  <div class="container">
    <div class="section__header section__header--center">
      <div class="section__label">Сравнение</div>
      <h2 class="section__title">Почему пробиотики лучше химии</h2>
      <p class="section__sub">Не верьте на слово — вот факты</p>
    </div>
    <div class="compare-wrap" style="background:var(--white);border:1px solid var(--border);border-radius:var(--radius-lg);overflow:hidden">
      <table class="compare-table">
        <thead>
          <tr>
            <th style="width:42%">Параметр</th>
            <th>Обычные средства</th>
            <th>Chrisal (пробиотики)</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ([
            ['Продолжает работать после высыхания', '✗ Нет — сразу перестают', '✓ До 3 суток'],
            ['Безопасно без перчаток и масок',      '✗ Химические пары',      '✓ Можно голыми руками'],
            ['Проникает в биоплёнку бактерий',      '✗ Только поверхность',   '✓ До микроскопического уровня'],
            ['Безопасно для детей и животных',      '✗ Нельзя детям до 3 лет','✓ Даже для новорождённых'],
            ['Один флакон = несколько применений',  '✗ Каждому своё средство','✓ До 8 применений'],
            ['Сертификат для медучреждений',        '✗ Как правило нет',      '✓ Вплоть до хирургии'],
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

<!-- HOW IT WORKS -->
<section class="section">
  <div class="container">
    <div class="section__header section__header--center">
      <div class="section__label">Технология</div>
      <h2 class="section__title">Как работают пробиотики</h2>
    </div>
    <div class="why-grid">
      <?php foreach ([
        ['🦠', 'Миллиарды живых бактерий',  'Пробиотики не маскируют грязь — они её поедают. Расщепляют органику до CO₂ и воды без химических остатков.'],
        ['⏱️', 'Работают трое суток',       'После высыхания остаются активными до 72 часов. Обычные средства перестают работать сразу же.'],
        ['🧬', 'Разрушают биоплёнку',       'Биоплёнка — щит вредных бактерий. Chrisal — единственное средство, которое её безопасно уничтожает.'],
        ['♻️', 'Концентрат 1:100',          'Один литр даёт 100 литров готового средства. Меньше пластика, меньше хранить, в 5 раз дешевле на литр.'],
      ] as [$icon, $title, $text]): ?>
        <div class="why-card">
          <div class="why-card__icon"><?= $icon ?></div>
          <h3 class="why-card__title"><?= $title ?></h3>
          <p class="why-card__text"><?= $text ?></p>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</section>

<!-- B2B -->
<section class="section section--soft">
  <div class="container">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:center">
      <div>
        <div class="section__label">Для бизнеса</div>
        <h2 class="section__title">Клининг, рестораны,<br>медицина, фермы</h2>
        <p style="color:var(--muted);margin-bottom:20px;line-height:1.7;font-size:.95rem">
          Профессиональные концентраты для промышленной уборки. Сотрудники работают без перчаток и масок. Валидировано независимыми больницами и Гентским университетом.
        </p>
        <ul style="list-style:none;display:flex;flex-direction:column;gap:10px;margin-bottom:28px">
          <?php foreach ([
            'Экономия 60–80% на моющих средствах',
            'Нет больничных от химических ожогов',
            'ХАССП-совместимо для пищевых производств',
            'Сертификат для хирургических кабинетов',
          ] as $point): ?>
            <li style="display:flex;align-items:center;gap:10px;font-size:.9rem;color:var(--muted)">
              <span style="width:20px;height:20px;background:var(--green-light);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.65rem;font-weight:800;color:var(--green-dark);flex-shrink:0">✓</span>
              <?= $point ?>
            </li>
          <?php endforeach ?>
        </ul>
        <div style="display:flex;gap:10px;flex-wrap:wrap">
          <a href="/catalog?audience=business" class="btn btn--primary">Товары для бизнеса</a>
          <a href="/order" class="btn btn--outline">Запросить КП</a>
        </div>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
        <?php foreach ([
          ['🏥','Медучреждения','Больницы, клиники, хирургия'],
          ['🍽️','Рестораны','Кухни, залы, ХАССП'],
          ['🏨','Отели','Номера, конференц-залы'],
          ['🐄','Агробизнес','Фермы, ветеринария, КРС'],
        ] as [$icon, $title, $desc]): ?>
          <div class="why-card" style="padding:16px">
            <div style="font-size:1.5rem;margin-bottom:8px"><?= $icon ?></div>
            <div style="font-size:.85rem;font-weight:800;color:var(--green-dark);margin-bottom:3px"><?= $title ?></div>
            <div style="font-size:.78rem;color:var(--muted2)"><?= $desc ?></div>
          </div>
        <?php endforeach ?>
      </div>
    </div>
  </div>
</section>

<script>
const allProds = <?= json_encode(array_values($allProducts)) ?>;

const segments = {
  home: {
    cta:'Смотреть товары для дома', link:'/catalog?audience=private', title:'Популярные для дома',
    scenes:[
      {icon:'🍳',title:'Кухня и посуда',desc:'Жир, запахи, все поверхности'},
      {icon:'🚿',title:'Ванная и санузел',desc:'Кафель, известняк, плесень'},
      {icon:'🧹',title:'Полы всех типов',desc:'Плитка, дерево, ламинат'},
      {icon:'🚗',title:'Автомобиль',desc:'Салон, кузов, стёкла'},
      {icon:'👕',title:'Стирка',desc:'Деликатные ткани, детское'},
      {icon:'🌿',title:'Аллергены',desc:'Клещи, пыльца, плесень'},
    ],
    filter: p => p.audience && p.audience.includes('private')
  },
  biz: {
    cta:'Товары для бизнеса', link:'/catalog?audience=business', title:'Для бизнеса и клининга',
    scenes:[
      {icon:'🏥',title:'Медучреждения',desc:'Сертификат до хирургии'},
      {icon:'🍽️',title:'Рестораны',desc:'Кухни, залы, ХАССП'},
      {icon:'🏨',title:'Отели',desc:'Номера, холлы, рестораны'},
      {icon:'🏢',title:'Офисы',desc:'Санузлы, переговорные'},
      {icon:'🧹',title:'Клининг',desc:'Экономия 60–80%'},
      {icon:'🐄',title:'Агробизнес',desc:'Фермы, производства'},
    ],
    filter: p => p.audience && p.audience.includes('business')
  },
  animals: {
    cta:'Товары для животных', link:'/catalog', title:'Для животных и ветеринарии',
    scenes:[
      {icon:'🐕',title:'Собаки и кошки',desc:'Вольеры, лотки, шерсть'},
      {icon:'🐄',title:'КРС и свиноводство',desc:'Стойла, кормушки'},
      {icon:'🐔',title:'Птицеводство',desc:'Птичники, инкубаторы'},
      {icon:'🐴',title:'Лошади',desc:'Конюшни, амуниция'},
      {icon:'🐠',title:'Аквариумы',desc:'Стёкла, фильтры'},
      {icon:'🌾',title:'Ветклиники',desc:'Операционные, боксы'},
    ],
    filter: p => true
  },
  water: {
    cta:'Товары для водоёмов', link:'/catalog', title:'Для водоёмов и систем воды',
    scenes:[
      {icon:'🏊',title:'Бассейны',desc:'Стены, дно, фильтры'},
      {icon:'⛲',title:'Фонтаны',desc:'Водоросли, биообрастание'},
      {icon:'🌊',title:'Пруды',desc:'Декоративные и рыбные'},
      {icon:'🚰',title:'Водоотведение',desc:'Трубы, дренаж, запахи'},
      {icon:'🐟',title:'Рыбоводство',desc:'УЗВ, садки'},
      {icon:'💧',title:'Водоподготовка',desc:'Биологическая очистка'},
    ],
    filter: p => true
  }
};

const calcItems = [
  {label:'Средство для пола',   price:320,bottles:12},
  {label:'Средство для посуды', price:280,bottles:12},
  {label:'Чистящее для ванной', price:350,bottles:6},
  {label:'Для унитаза',         price:230,bottles:12},
  {label:'Стеклоочиститель',    price:260,bottles:6},
  {label:'Пятновыводитель',     price:400,bottles:4},
  {label:'Для стирки',          price:600,bottles:4},
  {label:'Полироль для мебели', price:380,bottles:4},
];
const selected = new Set();

function renderScenarios(seg) {
  document.getElementById('scenario-grid').innerHTML =
    segments[seg].scenes.map(s =>
      `<div class="sc-card"><div class="sc-icon">${s.icon}</div><div class="sc-title">${s.title}</div><div class="sc-desc">${s.desc}</div></div>`
    ).join('');
}

function renderFeatured(seg) {
  const s = segments[seg];
  document.getElementById('featured-title').textContent = s.title;
  document.getElementById('featured-link').href = s.link;
  document.getElementById('hero-cta').textContent = s.cta;
  document.getElementById('hero-cta').href = s.link;
  const prods = allProds.filter(s.filter).slice(0, 4);
  document.getElementById('featured-grid').innerHTML = prods.map(p => `
    <div class="product-card">
      <a href="/catalog/${p.slug}" class="product-card__img">${p.image ? `<img src="${p.image}" alt="${p.name}">` : `<span style="font-size:3rem">🧴</span>`}</a>
      <div class="product-card__body">
        ${p.badge ? `<span class="product-card__badge">${p.badge}</span>` : ''}
        <a href="/catalog/${p.slug}" class="product-card__name">${p.name}</a>
        <p class="product-card__desc">${p.short_desc}</p>
        ${p.rating ? `<div class="product-card__rating"><span class="stars">${'★'.repeat(Math.round(p.rating))}${'☆'.repeat(5-Math.round(p.rating))}</span> <span style="color:var(--muted2);font-size:.75rem">(${p.reviews_count})</span></div>` : ''}
        <div class="product-card__footer">
          <div>
            <div class="product-card__price">${Number(p.price).toLocaleString('ru')} ₽</div>
            ${p.price_old > p.price ? `<div class="product-card__price-old">${Number(p.price_old).toLocaleString('ru')} ₽</div>` : ''}
          </div>
          <button class="btn btn--primary btn--sm" data-add-cart="${p.id}">В корзину</button>
        </div>
      </div>
    </div>`).join('') || '<p style="color:var(--muted);padding:20px 0">Товары этого раздела скоро появятся</p>';
}

document.querySelectorAll('.sw-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.sw-btn').forEach(b => b.classList.remove('sw-btn--active'));
    btn.classList.add('sw-btn--active');
    const seg = btn.dataset.seg;
    renderScenarios(seg);
    renderFeatured(seg);
  });
});

// Калькулятор
document.getElementById('calc-toggles').innerHTML = calcItems.map((it, i) =>
  `<span class="calc-toggle" data-i="${i}">${it.label}</span>`).join('');

document.querySelectorAll('.calc-toggle').forEach(el => {
  el.addEventListener('click', () => {
    const i = +el.dataset.i;
    selected.has(i) ? selected.delete(i) : selected.add(i);
    el.classList.toggle('calc-toggle--on');
    let saves = 0, bottles = 0;
    selected.forEach(j => { saves += calcItems[j].price * calcItems[j].bottles; bottles += calcItems[j].bottles; });
    const net = selected.size ? Math.max(0, saves - 10800) : 0;
    document.getElementById('r-items').textContent  = selected.size;
    document.getElementById('r-save').textContent   = net.toLocaleString('ru') + ' ₽';
    document.getElementById('r-plastic').textContent = bottles;
  });
});

renderScenarios('home');
renderFeatured('home');
</script>
<?php include SRC . '/Views/components/faq.php'; ?>

<!-- YOUTUBE -->
<section class="section">
    <div class="container">
        <div class="section__header section__header--center">
            <div class="section__label">YouTube</div>
            <h2 class="section__title">Смотрите нас на YouTube</h2>
            <p class="section__sub">Показываем как работают пробиотики, делаем обзоры и отвечаем на вопросы</p>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;max-width:900px;margin:0 auto">
            <div style="border-radius:var(--radius-lg);overflow:hidden;box-shadow:var(--shadow)">
                <iframe width="100%" height="280"
                    src="https://www.youtube.com/embed/Nhw3Ic4mlgM"
                    title="Probio-Clean видео 1"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
            </div>
            <div style="border-radius:var(--radius-lg);overflow:hidden;box-shadow:var(--shadow)">
                <iframe width="100%" height="280"
                    src="https://www.youtube.com/embed/IePGtFx0mVA"
                    title="Probio-Clean видео 2"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
            </div>
        </div>

        <div style="text-align:center;margin-top:24px">
            <a href="https://www.youtube.com/@probio-clean5864" target="_blank" class="btn btn--outline">
                Все видео на канале →
            </a>
        </div>
    </div>
</section>

<!-- ДО/ПОСЛЕ -->
<section class="section section--soft">
    <div class="container">
        <div class="section__header section__header--center">
            <div class="section__label">Результат</div>
            <h2 class="section__title">До и после</h2>
            <p class="section__sub">Реальные результаты применения пробиотических средств Chrisal</p>
        </div>

        <div style="columns:2;column-gap:12px;max-width:900px;margin:0 auto">
            <?php foreach([1,2,3,4,5,6,7,9] as $n): ?>
            <div style="break-inside:avoid;margin-bottom:12px;border-radius:var(--radius-lg);overflow:hidden;box-shadow:var(--shadow)">
                <img src="/img/effect/<?= $n ?>.webp" alt="До и после <?= $n ?>"
                     style="width:100%;display:block;max-height:480px;object-fit:cover">
            </div>
            <?php endforeach ?>
        </div>
    </div>
</section>
