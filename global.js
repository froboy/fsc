// * sIFR CONFIG
// ============================= */
var kievitBook = { src: '/sites/all/themes/fsc/kievit-book.swf' };
sIFR.activate(kievitBook);
sIFR.replace(kievitBook, {
  selector: 'h1.title',
  css: ['.sIFR-root {color:#749e6b;font-weight:normal;text-transform:uppercase;}'],
  wmode: 'transparent'
});

sIFR.replace(kievitBook, {
  selector: '.block-subject-cinema-amp-media-studies h2',
  css: [
  			'.sIFR-root {color:#d2eaee;font-weight:normal;text-transform:uppercase;}',
			'em {font-style:italic;}'
	   ],
  wmode: 'transparent'
});

sIFR.replace(kievitBook, {
  selector: '.slide h3',
  css: [
  			'.sIFR-root {height:30px;color:#2d2d2d;font-weight:normal;text-transform:uppercase;}',
			'em {font-style:italic;}'
	   ],
  wmode: 'transparent'
});