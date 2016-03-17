function arvore(objeto,ancora,classe) {
	this.objeto = objeto;
	this.ancora = ancora;
	this.imagens_diretorio = '../images/tree/classico/';
	this.imagens_largura = 16;
	this.imagens_altura = 22;
	this.imagens_alinhamento = 'absmiddle';
	this.mensagem_sem_itens = 'Nenhum grupo foi criado.'
	this.dados = new Array();
	this.itens = new Array();
	this.linhas = new Array();

	/* inseri itens na arvore */
	this.inserir_itens = function(nivel,conteudo) {
		this.dados[this.dados.length] = new Array();
		var indice = this.dados.length-1;
		this.dados[indice][0] = nivel;
		this.dados[indice][1] = conteudo;
	}

	/* gera informações de cada item como caminho, se é pai e nó */
	this.organiza_itens = function() {
		var i,a,b;
		var vetor = this.dados;
		if(typeof(vetor) == 'object' && vetor.length) {
			var familia = new Array();
			var linha = new Array();
			var caminho = '';
			for(i=0;i<vetor.length;i++) {
				// criando segunda dimensão do array
				familia[i] = new Array();
				linha[i] = new Array();
				// inicializando valores
				familia[i]['filho'] = '';
				familia[i]['irmao'] = '';
				linha[i]['caminho'] = '';
				linha[i]['noh'] = '';
				for(a=(i+1);a<vetor.length;a++) {
					if(vetor[i][0] < vetor[a][0]) {
						familia[i]['filho'] = true;
					} else if(vetor[i][0] == vetor[a][0]) {
						familia[i]['irmao'] = true;
						break;
					} else break;
				}
				for(a=1;a<vetor[i][0];a++) {
					for(b=(i-1);b>=0;b--) {
						if(vetor[b][0] == a) {
							if(familia[b]['irmao']) caminho = '8;';
							else caminho = '';
							break;
						}
					}
					if(!caminho) caminho = '7;';
					linha[i]['caminho'] += caminho;
				}
				if(linha[i]['caminho']) linha[i]['caminho'] = linha[i]['caminho'].substring(0,(linha[i]['caminho'].length-1));
				else linha[i]['caminho'] = '';
				if(familia[i]['filho'] && familia[i]['irmao'] && vetor[i][3]) linha[i]['noh'] = '1';
				else if(familia[i]['filho'] && familia[i]['irmao']) linha[i]['noh'] = "3";
				else if(familia[i]['filho'] && vetor[i][3]) linha[i]['noh'] = "2";
				else if(familia[i]['filho']) linha[i]['noh'] = "4";
				else if(familia[i]['irmao']) linha[i]['noh'] = "5";
				else linha[i]['noh'] = "6";
				// informações geradas do novo item
				this.itens[this.itens.length] = new Array();
				var indice = this.itens.length-1;
				this.itens[indice].nivel = vetor[i][0];
				this.itens[indice].pai = (familia[i]['filho'] ? true : false);
				this.itens[indice].caminho = (linha[i]['caminho'] ? linha[i]['caminho'] : '');
				this.itens[indice].noh = linha[i]['noh'];
				this.itens[indice].conteudo = vetor[i][1];
				this.itens[indice].fechado = (familia[i]['filho'] ? (vetor[i][3] ? true : false) : false);
				//
				caminho = 0;
				noh = 0;
			}
		}
	}

	/* converte a representacao numerica para as imagens dos nós */
	this.define_noh = function(noh) {
		if(noh == 1) noh = '<img src="'+this.imagens_diretorio+'aberto.gif" width="'+this.imagens_largura+'" height="'+this.imagens_altura+'" align="'+this.imagens_alinhamento+'">'; // aberto com filho e irmão
		else if(noh == 2) noh = '<img src="'+this.imagens_diretorio+'ultimo_aberto.gif" width="'+this.imagens_largura+'" height="'+this.imagens_altura+'" align="'+this.imagens_alinhamento+'">'; // último aberto com filho
		else if(noh == 3) noh = '<img src="'+this.imagens_diretorio+'fechado.gif" width="'+this.imagens_largura+'" height="'+this.imagens_altura+'" align="'+this.imagens_alinhamento+'">'; // fechado com filho e irmão
		else if(noh == 4) noh = '<img src="'+this.imagens_diretorio+'ultimo_fechado.gif" width="'+this.imagens_largura+'" height="'+this.imagens_altura+'" align="'+this.imagens_alinhamento+'">'; // último fechado com filho
		else if(noh == 5) noh = '<img src="'+this.imagens_diretorio+'sem_filho.gif" width="'+this.imagens_largura+'" height="'+this.imagens_altura+'" align="'+this.imagens_alinhamento+'">'; // sem filho e com irmão
		else if(noh == 6) noh = '<img src="'+this.imagens_diretorio+'ultimo.gif" width="'+this.imagens_largura+'" height="'+this.imagens_altura+'" align="'+this.imagens_alinhamento+'">'; // último sem filho
		return noh;
	}

	/* converte a representacao numerica para a imagem da linha ou espaco */
	this.organiza_caminho = function(caminho) {
		var i;
		var caminho = caminho.split(';');
		var organizado = '';
		for(i=0;i<caminho.length;i++) {
			if(caminho[i] == 7) caminho[i] = '<img src="'+this.imagens_diretorio+'transparente.gif" width="'+this.imagens_largura+'" height="'+this.imagens_altura+'" align="'+this.imagens_alinhamento+'">'; // espaço
			else if(caminho[i] == 8) caminho[i] = '<img src="'+this.imagens_diretorio+'caminho.gif" width="'+this.imagens_largura+'" height="'+this.imagens_altura+'" align="'+this.imagens_alinhamento+'">'; // linha do caminho
			organizado += caminho[i];
		}
		return organizado;
	}

	/* constroi a arvore */
	this.construir = function() {
		var i;
		this.organiza_itens();
		if(this.itens.length) {
			for(i=0;i<this.itens.length;i++) {
				this.linhas[i] = document.createElement("div");
				this.linhas[i].className = classe;
				this.linhas[i].innerHTML = this.organiza_caminho(this.itens[i].caminho)+(this.itens[i].pai ? '<span id="'+this.ancora+'_noh'+i+'" onClick="javascript:'+this.objeto+'.abrir_fechar_item('+i+');">' : '')+this.define_noh(this.itens[i].noh)+(this.itens[i].pai ? '</span>' : '')+this.itens[i].conteudo;
				document.getElementById(this.ancora).appendChild(this.linhas[i]);
			}
			this.abrir_fechar_arvore();
		} else this.ancora.innerHTML = this.mensagem_sem_itens;
	}

	/* remove todos itens */
	this.remover_itens = function() {
		while(this.itens.length) this.itens.shift();
		while(this.linhas.length) this.linhas.shift();
	}

	/* abre/fecha toda arvore */
	this.abrir_fechar_arvore = function() {
		for(i=0;i<this.itens.length;i++) this.abrir_fechar_item(i);
	}

	/* abre/fecha o item clicando sobre o nó */
	this.abrir_fechar_item = function(linha) {
		var i;
		var fechado = false;
		this.itens[linha].fechado = (this.itens[linha].fechado ? false : true);

		// muda ícone dos nó
		if(this.itens[linha].pai) {
			if(!this.itens[linha].fechado) {
				if(this.itens[linha].noh == 1) this.itens[linha].noh = 3;
				else if(this.itens[linha].noh == 2) this.itens[linha].noh = 4;
			} else {
				if(this.itens[linha].noh == 3) this.itens[linha].noh = 1;
				else if(this.itens[linha].noh == 4) this.itens[linha].noh = 2;
			}
			document.getElementById(this.ancora+'_noh'+linha).innerHTML = this.define_noh(this.itens[linha].noh);
		}

		for(i=(linha+1);i<this.linhas.length;i++) {
			if(this.itens[i].nivel > this.itens[linha].nivel) {
				if(this.itens[linha].fechado) {
					if(fechado && this.itens[i].nivel <= this.itens[fechado].nivel) fechado = false;
					if(fechado && this.itens[i].nivel > this.itens[fechado].nivel) this.linhas[i].style.display = 'none';
					else this.linhas[i].style.display = '';
					if(!fechado && !this.itens[i].fechado) fechado = i;
				} else this.linhas[i].style.display = 'none';
			} else break;
		}
		fechado = false;
	}

	/* abre toda ramificação de um item */
	this.abrir_ramificacao = function(linha,pai) {
		var i;
		if(!pai) {
			pai = new Array();
			pai[0] = linha;
			this.itens[linha].fechado = false;
		}
		for(i=linha-1;i>=0;i--) {
			if(this.itens[i].nivel < this.itens[linha].nivel) {
				pai.unshift(i);
				this.itens[i].fechado = false;
				return this.abrir(i,pai);
			}
		}
		for(i=0;i<pai.length;i++) this.abrir_fechar_item(pai[i]);
		return true;
	}
}