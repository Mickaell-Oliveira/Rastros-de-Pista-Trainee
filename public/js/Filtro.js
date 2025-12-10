        document.addEventListener("DOMContentLoaded", () => {
            const inputHidden = document.getElementById('filtro-tags-hidden');
            if (inputHidden && inputHidden.value) {
                const listaTags = inputHidden.value.split(',');
                const tagsExistentes = document.querySelectorAll('.tag-item');
                const valoresExistentes = Array.from(tagsExistentes).map(t => t.getAttribute('data-value'));

                tagsExistentes.forEach(tag => {
                    if (listaTags.includes(tag.getAttribute('data-value'))) {
                        tag.classList.add('ativo');
                    }
                });

                const container = document.getElementById('lista-tags');
                listaTags.forEach(valorTag => {
                    const valorLimpo = valorTag.trim();
                    if (!valoresExistentes.includes(valorLimpo) && valorLimpo !== "") {
                        criarElementoTag(valorLimpo, container, true);
                    }
                });
            }
        });

        function alternarTag(elemento) {
            elemento.classList.toggle('ativo');
            atualizarInputTags();
        }

        function criarElementoTag(texto, container, ativo = true) {
            const novaTag = document.createElement('div');
            novaTag.className = ativo ? 'tag-item ativo' : 'tag-item';
            novaTag.setAttribute('data-value', texto);
            novaTag.innerText = texto;
            novaTag.onclick = function() { alternarTag(this) };
            container.appendChild(novaTag);
        }

        function criarTagAoDigitar(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                const input = document.getElementById('input-tag-busca');
                const valor = input.value.trim();
                
                if (valor) {
                    const container = document.getElementById('lista-tags');
                    let existe = false;
                    document.querySelectorAll('.tag-item').forEach(t => {
                        if(t.getAttribute('data-value').toLowerCase() === valor.toLowerCase()) existe = true;
                    });

                    if (!existe) {
                        criarElementoTag(valor, container, true);
                    }
                    input.value = "";
                    atualizarInputTags();
                }
            }
        }

        function atualizarInputTags() {
            const tagsAtivas = document.querySelectorAll('.tag-item.ativo');
            const valores = Array.from(tagsAtivas).map(tag => tag.getAttribute('data-value'));
            document.getElementById('filtro-tags-hidden').value = valores.join(',');
        }

        function aplicarFiltros() {
            const buscaPrincipal = document.getElementById('searchInput') ? document.getElementById('searchInput').value : '';
            const tipo = document.getElementById('filtro-tipo').value;
            const ano = document.getElementById('filtro-ano').value;
            const tags = document.getElementById('filtro-tags-hidden').value;

            const params = new URLSearchParams();
            if (buscaPrincipal) params.append('busca', buscaPrincipal);
            if (tipo) params.append('tipo', tipo);
            if (ano) params.append('ano', ano);
            if (tags) params.append('tags', tags);

            window.location.href = window.location.pathname + '?' + params.toString();
        }