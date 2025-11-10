
(function () {
	
	const container = document.getElementById('footer_container');
	const primary = document.getElementById('primary_footer');
	if (!container || !primary) return;

	primary.addEventListener('click', function () {
	
		if (window.innerWidth <= 768) {
			container.classList.toggle('open');
			if (container.classList.contains('open')) {
			
				container.scrollIntoView({ behavior: 'smooth', block: 'end' });
			}
		}
	});
})();
