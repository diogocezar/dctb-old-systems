var MENU_1 = [
	['Administrativo', null, null,
		['Usu�rios', null, null,
			['Cadastrar', 'frmUsuario.php?acao=adicionar'],
			['Gerenciar', 'gerenciar.php?tabela=usuario&campos=2,3'],
			['N�vel de administra��o', null, null,
				 ['Cadastrar', 'frmNivel.php?acao=adicionar'],
				 ['Gerenciar', 'gerenciar.php?tabela=nivel&campos=1'],
			 ],
		],
		['Fornecedor', null, null,
			['Cadastrar', 'frmFornecedor.php?acao=adicionar'],
			['Gerenciar', 'gerenciarPessoa.php?tabela=fornecedor&campos=g4,p5'],
		],
		['Agregado', null, null,
			['Cadastrar', 'frmAgregado.php?acao=adicionar'],
			['Gerenciar', 'gerenciarPessoa.php?tabela=agregado&campos=g2,p5'],
		],
		['Ve�culo', null, null,
			 ['Cadastrar', 'frmVeiculo.php?acao=adicionar'],
			 ['Gerenciar', 'gerenciar.php?tabela=veiculo&campos=3'],
			 ['Categoria', null, null,
				['Cadastrar', 'frmCategoria.php?acao=adicionar'],
				['Gerenciar', 'gerenciar.php?tabela=categoria&campos=1'],
			 ],
		 ],
	],
	['Cliente', null, null,
		['Cadastrar', 'frmCliente.php?acao=adicionar'],
		['Gerenciar', 'gerenciarPessoa.php?tabela=cliente&campos=g3,p5'],
		['Contato', null, null,
			['Cadastrar', 'frmContato.php?acao=adicionar'],
			['Gerenciar', 'gerenciarContato.php?tabela=contato&campos=2,3'],
		],
		['Freq�encia Coleta', null, null,
			 ['Cadastrar', 'frmFrequenciacoleta.php?acao=adicionar'],
			 ['Gerenciar', 'gerenciar.php?tabela=frequenciacoleta&campos=1'],
		 ],
	],
	['Coleta', null, null,
		['Cadastrar', 'frmColeta.php?acao=adicionar'],
		['Gerenciar', 'gerenciarColeta.php?tabela=coleta&campos=2,13,14'],
		['Roteirizar', 'gerenciarColeta.php?tabela=coleta&campos=2,13,14&opcao=roteirizar'],
		['Status', null, null,
			['Cadastrar', 'frmStatus.php?acao=adicionar'],
			['Gerenciar', 'gerenciar.php?tabela=status&campos=1'],
		],
		['Motivo', null, null,
			['Cadastrar', 'frmMotivo.php?acao=adicionar'],
			['Gerenciar', 'gerenciar.php?tabela=motivo&campos=1'],
		],
		['Embalagem', null, null,
			['Cadastrar', 'frmEmbalagem.php?acao=adicionar'],
			['Gerenciar', 'gerenciar.php?tabela=embalagem&campos=1'],
		],
		['Restri��o', null, null,
			['Cadastrar', 'frmRestricao.php?acao=adicionar'],
			['Gerenciar', 'gerenciar.php?tabela=restricao&campos=1'],
		],
	],
	['Distribui��o', null, null,
		['MTC - Carga', null, null,
			['Cadastrar', 'frmManifesto.php?acao=adicionar'],
			['Gerenciar', 'gerenciarManifesto.php?tabela=manifesto&campos=3'],
			['Status Manifesto', null, null,
				['Cadastrar', 'frmStatusManifesto.php?acao=adicionar'],
				['Gerenciar', 'gerenciar.php?tabela=statusmanifesto&campos=1'],
			 ],
		],
		['Conhecimento', null, null,
			['Cadastrar', 'frmConhecimento.php?acao=adicionar'],
			['Gerenciar', 'gerenciarConhecimento.php?tabela=conhecimento&campos=2'],
			['Status Conhecimento', null, null,
				['Cadastrar', 'frmStatusConhecimento.php?acao=adicionar'],
				['Gerenciar', 'gerenciar.php?tabela=statusconhecimento&campos=1'],
			 ],
		],
		['MEC - Carga', null, null,
		 	['Cadastrar', 'frmSaidamanifesto.php?acao=adicionar'],
			['Gerenciar', 'gerenciar.php?tabela=saidamanifesto&campos=1'],
		],
		['Baixa - CTRC', null, null,
		 	['Cadastrar', 'frmBaixaConhecimento.php?acao=adicionar'],
			['Gerenciar', 'gerenciar.php?tabela=baixaconhecimento&campos=2'],
		],	
	],
	['Relat�rios', 'frmRelatorios.php'],
	];


var MENU_2 = MENU_1;

var MENU_3 = [
	['Cliente', null, null,
		['Cadastrar', 'frmCliente.php?acao=adicionar'],
		['Gerenciar', 'gerenciarPessoa.php?tabela=cliente&campos=g3,p5'],
		['Contato', null, null,
			['Cadastrar', 'frmContato.php?acao=adicionar'],
			['Gerenciar', 'gerenciarContato.php?tabela=contato&campos=2,3'],
		],
		['Freq�encia Coleta', null, null,
			 ['Cadastrar', 'frmFrequenciacoleta.php?acao=adicionar'],
			 ['Gerenciar', 'gerenciar.php?tabela=frequenciacoleta&campos=1'],
		 ],
	],
	['Coleta', null, null,
		['Cadastrar', 'frmColeta.php?acao=adicionar'],
		['Gerenciar', 'gerenciarColeta.php?tabela=coleta&campos=2,13,14'],
		['Roteirizar', 'gerenciarColeta.php?tabela=coleta&campos=2,13,14&opcao=roteirizar'],
		['Status', null, null,
			['Cadastrar', 'frmStatus.php?acao=adicionar'],
			['Gerenciar', 'gerenciar.php?tabela=status&campos=1'],
		],
		['Motivo', null, null,
			['Cadastrar', 'frmMotivo.php?acao=adicionar'],
			['Gerenciar', 'gerenciar.php?tabela=motivo&campos=1'],
		],
		['Embalagem', null, null,
			['Cadastrar', 'frmEmbalagem.php?acao=adicionar'],
			['Gerenciar', 'gerenciar.php?tabela=embalagem&campos=1'],
		],
		['Restri��o', null, null,
			['Cadastrar', 'frmRestricao.php?acao=adicionar'],
			['Gerenciar', 'gerenciar.php?tabela=restricao&campos=1'],
		],
	],
	['Administrativo', null, null,
		['Fornecedor', null, null,
			['Cadastrar', 'frmFornecedor.php?acao=adicionar'],
			['Gerenciar', 'gerenciarPessoa.php?tabela=fornecedor&campos=g4,p5'],
		],
		['Agregado', null, null,
			['Cadastrar', 'frmAgregado.php?acao=adicionar'],
			['Gerenciar', 'gerenciarPessoa.php?tabela=agregado&campos=g2,p5'],
		],
		['Ve�culo', null, null,
			 ['Cadastrar', 'frmVeiculo.php?acao=adicionar'],
			 ['Gerenciar', 'gerenciar.php?tabela=veiculo&campos=3'],
			 ['Categoria', null, null,
				['Cadastrar', 'frmCategoria.php?acao=adicionar'],
				['Gerenciar', 'gerenciar.php?tabela=categoria&campos=1'],
			 ],
		 ],
	],
	['Distribui��o', null, null,
		['MTC - Carga', null, null,
			['Cadastrar', 'frmManifesto.php?acao=adicionar'],
			['Gerenciar', 'gerenciarManifesto.php?tabela=manifesto&campos=3'],
			['Status Manifesto', null, null,
				['Cadastrar', 'frmStatusManifesto.php?acao=adicionar'],
				['Gerenciar', 'gerenciar.php?tabela=statusmanifesto&campos=1'],
			 ],
		],
		['Conhecimento', null, null,
			['Cadastrar', 'frmConhecimento.php?acao=adicionar'],
			['Gerenciar', 'gerenciarConhecimento.php?tabela=conhecimento&campos=2'],
			['Status Conhecimento', null, null,
				['Cadastrar', 'frmStatusConhecimento.php?acao=adicionar'],
				['Gerenciar', 'gerenciar.php?tabela=statusconhecimento&campos=1'],
			 ],
		],
		['MEC - Carga', null, null,
		 	['Cadastrar', 'frmSaidamanifesto.php?acao=adicionar'],
			['Gerenciar', 'gerenciar.php?tabela=saidamanifesto&campos=1'],
		],
		['Baixa - CTRC', null, null,
		 	['Cadastrar', 'frmBaixaConhecimento.php?acao=adicionar'],
			['Gerenciar', 'gerenciar.php?tabela=baixaconhecimento&campos=2'],
		],	
	],
];

var MENU_4 = [
	['Coleta', null, null,
		['Cadastrar', 'frmColeta.php?acao=adicionar'],
		['Gerenciar', 'gerenciarColeta.php?tabela=coleta&campos=2,13,14'],
		['Status', null, null,
			['Cadastrar', 'frmStatus.php?acao=adicionar'],
			['Gerenciar', 'gerenciar.php?tabela=status&campos=1'],
		],
		['Motivo', null, null,
			['Cadastrar', 'frmMotivo.php?acao=adicionar'],
			['Gerenciar', 'gerenciar.php?tabela=motivo&campos=1'],
		],
		['Embalagem', null, null,
			['Cadastrar', 'frmEmbalagem.php?acao=adicionar'],
			['Gerenciar', 'gerenciar.php?tabela=embalagem&campos=1'],
		],
		['Restri��o', null, null,
			['Cadastrar', 'frmRestricao.php?acao=adicionar'],
			['Gerenciar', 'gerenciar.php?tabela=restricao&campos=1'],
		],
	],
	['Administrativo', null, null,
		['Fornecedor', null, null,
			['Cadastrar', 'frmFornecedor.php?acao=adicionar'],
			['Gerenciar', 'gerenciarPessoa.php?tabela=fornecedor&campos=g4,p5'],
		],
	],
	['Cliente', null, null,
		['Cadastrar', 'frmCliente.php?acao=adicionar'],
		['Gerenciar', 'gerenciarPessoa.php?tabela=cliente&campos=g3,p5'],
		['Contato', null, null,
			['Cadastrar', 'frmContato.php?acao=adicionar'],
			['Gerenciar', 'gerenciarContato.php?tabela=contato&campos=2,3'],
		],
		['Freq�encia Coleta', null, null,
			 ['Cadastrar', 'frmFrequenciacoleta.php?acao=adicionar'],
			 ['Gerenciar', 'gerenciar.php?tabela=frequenciacoleta&campos=1'],
		 ],
	],
	['Distribui��o', null, null,
		['MTC - Carga', null, null,
			['Cadastrar', 'frmManifesto.php?acao=adicionar'],
			['Gerenciar', 'gerenciarManifesto.php?tabela=manifesto&campos=3'],
			['Status Manifesto', null, null,
				['Cadastrar', 'frmStatusManifesto.php?acao=adicionar'],
				['Gerenciar', 'gerenciar.php?tabela=statusmanifesto&campos=1'],
			 ],
		],
		['Conhecimento', null, null,
			['Cadastrar', 'frmConhecimento.php?acao=adicionar'],
			['Gerenciar', 'gerenciarConhecimento.php?tabela=conhecimento&campos=2'],
			['Status Conhecimento', null, null,
				['Cadastrar', 'frmStatusConhecimento.php?acao=adicionar'],
				['Gerenciar', 'gerenciar.php?tabela=statusconhecimento&campos=1'],
			 ],
		],
		['MEC - Carga', null, null,
		 	['Cadastrar', 'frmSaidamanifesto.php?acao=adicionar'],
			['Gerenciar', 'gerenciar.php?tabela=saidamanifesto&campos=1'],
		],
		['Baixa - CTRC', null, null,
		 	['Cadastrar', 'frmBaixaConhecimento.php?acao=adicionar'],
			['Gerenciar', 'gerenciar.php?tabela=baixaconhecimento&campos=2'],
		],	
	],
];
