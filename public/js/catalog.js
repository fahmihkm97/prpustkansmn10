// Filter katalog di sisi klien (cari + kategori + ketersediaan)
(function () {
  const cards = [...document.querySelectorAll('.book-card')];
  if (!cards.length) return;
  const q = document.getElementById('q');
  const avail = document.getElementById('f-avail');
  const count = document.getElementById('count');
  const boxes = [...document.querySelectorAll('input.f-cat')];
  const chips = [...document.querySelectorAll('.chip[data-cat]')];
  const empty = document.getElementById('no-result');

  function apply() {
    const term = (q ? q.value : '').trim().toLowerCase();
    const cats = boxes.filter(b => b.checked).map(b => b.value)
      .concat(chips.filter(c => c.classList.contains('on')).map(c => c.dataset.cat));
    let shown = 0;
    cards.forEach(c => {
      const hay = (c.dataset.title + ' ' + c.dataset.author + ' ' + c.dataset.cat).toLowerCase();
      const ok = (!term || hay.includes(term))
        && (!cats.length || cats.includes(c.dataset.cat))
        && (!(avail && avail.checked) || c.dataset.avail === '1');
      c.style.display = ok ? '' : 'none';
      if (ok) shown++;
    });
    if (count) count.textContent = 'Menampilkan ' + shown + ' buku';
    if (empty) empty.style.display = shown ? 'none' : '';
  }
  if (q) q.addEventListener('input', apply);
  if (avail) avail.addEventListener('change', apply);
  boxes.forEach(b => b.addEventListener('change', apply));
  chips.forEach(c => c.addEventListener('click', () => { c.classList.toggle('on'); apply(); }));
  apply();
})();
