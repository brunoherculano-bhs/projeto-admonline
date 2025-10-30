<?php
/**
 * FormVerticalBuilderView
 *
 * @version    1.0
 * @package    samples
 * @subpackage tutor
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    https://adiantiframework.com.br/license-tutor
 */


use Adianti\Control\TPage;
use Adianti\Widget\Form\TCheckButton;
use Adianti\Widget\Form\TButton;
use Adianti\Widget\Form\TFile;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class func_cadastro extends TPage
{
    private $form;
    //protected $form;
    use Adianti\Base\AdiantiFileSaveTrait;

    public function __construct()
    {
        parent::__construct();
        parent::include_js('app/lib/include/application.js');
        
        $this->form = new BootstrapFormBuilder('func_cadastro');
        $this->form->setFormTitle('Encaminhamento de Admissão');
        $this->form->setFieldSizes('100%');
        $this->form->generateAria(); // automatic aria-label

        // nome da empresa logada e id  
        $username = TSession::getValue('userunitname');
        $usernameid = TSession::getValue('userunitid');

         $xemp = new THidden('emp');
        //if ($username == 'Fortal-015')
        //{
        //   $xemp->setValue('015');
        //}
        
        switch ($usernameid) {
            case '1':
                $xemp->setValue('001');
                break;
            case '2':
                $xemp->setValue('002');
                break;
            case '3':
                $xemp->setValue('003');
                break;
            case '4':
                $xemp->setValue('004');
                break;
            case '5':
                $xemp->setValue('005');
                break;
            case '6':
                $xemp->setValue('006');
                break;
            case '7':
                $xemp->setValue('007');
                break;
        //default:
        }
        
        
        $user_id = TSession::getValue('userid');
        $formatted_id = str_pad($user_id, 5, '0', STR_PAD_LEFT);
        $xmat = new THidden('mat');
        $xmat->setValue($formatted_id);
        $xmat->setEditable(FALSE);
        $xemp->setEditable(FALSE);
       
        


        
        /* PADRÕES DE COMBOS PARA SEREM USADOS NOS CAMPOS */

        $xparent = [ '0'=>'Filho','1'=>'Cônjuge','2'=>'Outros'];

        $xchncategoria = [
            'A'   => 'A',
            'B'   => 'B',
            'A/B' => 'A/B',
            'C'   => 'C',
            'D'   => 'D',
            'E'   => 'E'
        ];
        // 1=Indio,2=Branca,4=Preta,6=Amarela,8=Parda,9=NI
        $xracacor = [
            '1' => 'Indígena',
            '2' => 'Branca',
            '4' => 'Preta',
            '6' => 'Amarela',
            '8' => 'Parda',
            '9' => 'Outra'
        ];

        //$xgrau = ['Ensino Fundamental','Ensino Médio','Ensino Técnico','Graduação','Pós-Graduação','Mestrado','Doutorado'];
        //Analfabeto,1,Até 5a Série Incompleta,2,5a Série Completa,3,De 5o a 8o Incompleto,4,1o Grau completo,5,Médio incompleto,6,Médio Completo,7,Superior Incompleto,8,Superior Completo,9,Pós-Graduação,10,Mestrado,11,Doutorado,12
        $xgrau = [
            '1' => 'Analfabeto',
            '2' => 'Até 5a Série Incompleta',
            '3' => '5a Série Completa',
            '4' => 'De 5o a 8o Incompleto',
            '5' => '1o Grau completo',
            '6' => 'Médio incompleto',
            '7' => 'Médio Completo',
            '8' => 'Superior Incompleto',
            '9' => 'Superior Completo',
            '10' => 'Pós-Graduação',
            '11' => 'Mestrado',
            '12' => 'Doutorado'
            ];

        $xsim = ['S' => 'Sim','N' => 'Não'];
        $xsexcombo = [ 'M'=>'Masculino','F'=>'Feminino','N'=>'Não Informar'];
        $xnacionalidade = [
            '10'=>'BRASILEIRO',
            '20'=>'NATURALIZADO / BRASILEIRO',
            '21'=>'ARGENTINO',
            '22'=>'BOLIVIANO',
            '23'=>'CHILENO',
            '24'=>'PARAGUAIO',
            '25'=>'URUGUAIO',
            '26'=>'DOMINICANO',
            '30'=>'ALEMÃO',
            '31'=>'BELGA',
            '32'=>'BRITÂNICO',
            '34'=>'CANADENSE',
            '35'=>'ESPANHOL',
            '36'=>'NORTE-AMERICANO (EUA)',
            '37'=>'FRANCÊS',
            '38'=>'SUÍÇO',
            '39'=>'ITALIANO',    
            '41'=>'JAPONÊS',
            '42'=>'CHINÊS',
            '43'=>'COREANO',
            '45'=>'PORTUGUÊS',
            '48'=>'OUTROS LATINO-AMERICANOS',
            '49'=>'OUTROS ASIÁTICOS',
            '50'=>'OUTROS',

        ];

        $xufcombo = [     
        'AC' => 'Acre',
        'AL' => 'Alagoas',
        'AP' => 'Amapá',
        'AM' => 'Amazonas',
        'BA' => 'Bahia',
        'CE' => 'Ceará',
        'DF' => 'Distrito Federal',
        'ES' => 'Espírito Santo',
        'GO' => 'Goiás',
        'MA' => 'Maranhão',
        'MT' => 'Mato Grosso',
        'MS' => 'Mato Grosso do Sul',
        'MG' => 'Minas Gerais',
        'PA' => 'Pará',
        'PB' => 'Paraíba',
        'PR' => 'Paraná',
        'PE' => 'Pernambuco',
        'PI' => 'Piauí',
        'RJ' => 'Rio de Janeiro',
        'RN' => 'Rio Grande do Norte',
        'RS' => 'Rio Grande do Sul',
        'RO' => 'Rondônia',
        'RR' => 'Roraima',
        'SC' => 'Santa Catarina',
        'SP' => 'São Paulo',
        'SE' => 'Sergipe',
        'TO' => 'Tocantins'

        ];

        $xfardacamisa = [
            'PP'=>'PP','P'=>'P','M'=>'M','G'=>'G','GG'=>'GG','XGG'=>'XGG'
        ];
        $xfardacalca = [
            '36' => '36','38' => '38','40' => '40','42' => '42','44' => '44',
            '46' => '46','48' => '48','50' => '50','52' => '52','53' => '53'
        ];
        $xfardasapato = [
            '33' => '33','34' => '34','35' => '35','36' => '36','37' => '37', 
            '38' => '38','39' => '39','40' => '40','41' => '41','42' => '42',
            '43' => '43','44' => '44','45' => '45','46' => '46'
        ];

        //Solteiro,1,Casado,2,Viúvo,3,Separado,4,Desquitado,5,Divorciado,6,Amaziado,7,União estável,8

        $xcasado = [
            '1' => 'Solteiro',
            '2' => 'Casado', 
            '3' => 'Viúvo',
            '4' => 'Separado',
            '5' => 'Desquitado',
            '6' => 'Divorciado',
            '7' => 'Amaziado',
            '8' => 'União Estavel'
        ];

        //Deficiência Física. (Branco)=Nao 1=Fisica 2=Auditiva 3=Visual 4=Mental 5=Multipla

        $xdeficiencia = [
            '0' => 'Sem deficiência',
            '1' => 'Física',
            '2' => 'Auditiva', 
            '3' => 'Visual',
            '4' => 'Mental', 
            '5' => 'Multipla'
        ];

       
        ///////////////////////////////////
        /* INICIO DAS ABAS DO FORMULARIO */
        ///////////////////////////////////


        $this->form->appendPage('Cadastro');
        
        $xdes = new TEntry('des');
        $xdes->setProperty('style', 'text-transform:uppercase');
        $xnac = new TCombo('nac');
        $xnac->addItems($xnacionalidade);
        $xnas = new TDate('nas');
        $xnas->setMask('dd/mm/yyyy');
        $xsex = new TCombo('sex');
        $xsex->addItems($xsexcombo);
        $xmae = new TEntry('mae');
        $xmae->setProperty('style', 'text-transform:uppercase');
        $xgue = new TEntry('gue');
        $xgue->setProperty('style', 'text-transform:uppercase');
        $xlug = new TEntry('lug');
        $xlug->setProperty('style', 'text-transform:uppercase');
        $xsit = new TCombo('sit');
        $xsit->addItems($xcasado);
        $xrac = new TCombo('rac');
        $xrac->addItems($xracacor);
        $xpai = new TEntry('pai');
        $xpai->setProperty('style', 'text-transform:uppercase');
        $xdef = new TCombo('def');
        $xdef->addItems($xdeficiencia);

        $row = $this->form->addFields([$xmat,$xemp]);
        $row->layout = ['col-sm-2','col-sm-2'];

        $row = $this->form->addFields([new TLabel('Nome do Trabalhador:*'), $xdes]);
        $row->layout = ['col-sm-4'];
        $row = $this->form->addFields([new TLabel('Nome Social:'), $xgue]);
        $row->layout = ['col-sm-4'];
        $row = $this->form->addFields([new TLabel('Nacionalidade:*'), $xnac]);
        $row->layout = ['col-sm-4'];
        $row = $this->form->addFields([new TLabel('Naturalidade:*'), $xlug]);
        $row->layout = ['col-sm-4'];
        $row = $this->form->addFields([new TLabel('Data de Nascimento:*'), $xnas]);
        $row->layout = ['col-sm-4'];
        $row = $this->form->addFields([new TLabel('Gênero:*'), $xsex]);
        $row->layout = ['col-sm-4'];
        $row = $this->form->addFields([new TLabel('Nome da Mãe:*'), $xmae]);
        $row->layout = ['col-sm-4'];
        $row = $this->form->addFields([new TLabel('Nome do Pai:'), $xpai]);
        $row->layout = ['col-sm-4'];
        $row = $this->form->addFields([new TLabel('Estado Civil:*'), $xsit]);
        $row->layout = ['col-sm-4'];
        $row = $this->form->addFields([new TLabel('Raça ou Cor:*'), $xrac]);
        $row->layout = ['col-sm-4'];
        $row = $this->form->addFields([new TLabel('Deficiência:*'), $xdef]);
        $row->layout = ['col-sm-4'];

        $this->form->appendPage('Documentação');

        $xcpf = new TEntry('cpf');
        $xcpf->setMask('999.999.999-99');
        $xcpf->setMaxLength(11);
        $xcpf->setExitAction(new TAction([$this, 'onValidaCpf']));
        $xide = new TEntry('ide');
        $xrgu = new TCombo('rgu');
        $xrgu->addItems($xufcombo);
        $xctm = new TEntry('ctm');
        $xcam = new TCombo('cam');
        $xcam->addItems($xchncategoria);
        $xpis = new TEntry('pis');
        $xssp = new TEntry('ssp');
        $xssp->setProperty('style', 'text-transform:uppercase');
        $xdti = new TDate('dti');
        $xdti->setMask('dd/mm/yyyy');
        $xins = new TCombo('ins');
        $xins->addItems($xgrau);
        $xele = new TEntry('ele');
        $xzon = new TEntry('zon');
        $xsec = new TEntry('sec');
                                 
        $row = $this->form->addFields([new TLabel('CPF:*'), $xcpf]);
        $row->layout = ['col-sm-4'];
        $row = $this->form->addFields([new TLabel('PIS:'), $xpis]);
        $row->layout = ['col-sm-4'];
        $row = $this->form->addFields([new TLabel('RG:*'), $xide]);
        $row->layout = ['col-sm-4'];
        $row = $this->form->addFields([new TLabel('Órgão Emissor RG:*'), $xssp]);
        $row->layout = ['col-sm-4'];
        $row = $this->form->addFields([new TLabel('UF Emissor RG:*'), $xrgu]);
        $row->layout = ['col-sm-4'];
        $row = $this->form->addFields([new TLabel('Data de Emissão RG:*'), $xdti]);
        $row->layout = ['col-sm-4'];
        $row = $this->form->addFields([new TLabel('CNH:'), $xctm]);
        $row->layout = ['col-sm-4'];
        $row = $this->form->addFields([new TLabel('Categoria:'), $xcam]);
        $row->layout = ['col-sm-4'];
        $row = $this->form->addFields([new TLabel('Escolaridade:*'), $xins]);
        $row->layout = ['col-sm-4'];
        $row = $this->form->addFields([new TLabel('Eleitor:'), $xele]);
        $row->layout = ['col-sm-4'];
        $row = $this->form->addFields([new TLabel('Zona:'), $xzon]);
        $row->layout = ['col-sm-4'];
        $row = $this->form->addFields([new TLabel('Seção:'), $xsec]);
        $row->layout = ['col-sm-4'];

        $this->form->appendPage('Endereço e Contato');
        $xcep = new TEntry('cep');
        $xend = new TEntry('end');
        $xend->setProperty('style', 'text-transform:uppercase');
        $xcpl = new TEntry('cpl');
        $xcpl->setProperty('style', 'text-transform:uppercase');
        $xcid = new TEntry('cid');
        $xcid->setProperty('style', 'text-transform:uppercase');
        $xema = new TEntry('ema');
        $xema->setProperty('style', 'text-transform:uppercase');
        $xbai = new TEntry('bai');
        $xbai->setProperty('style', 'text-transform:uppercase');
        $xnum = new TEntry('num');
        $xesr = new TEntry('esr');
        $xesr->setProperty('style', 'text-transform:uppercase');
        $xtel = new TEntry('tel');
        $xcel = new TEntry('cel');

        $script = "
            // Função para preencher os campos de rua, bairro, cidade e estado
            function preencherCampos(endereco) {
                document.getElementById('".$xend->getId()."').value = endereco.logradouro;
                document.getElementById('".$xbai->getId()."').value = endereco.bairro;
                document.getElementById('".$xcid->getId()."').value = endereco.localidade;
                document.getElementById('".$xesr->getId()."').value = endereco.uf;
            }

            // Função para buscar o CEP e preencher os campos
            function buscarCep(cep) {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'https://viacep.com.br/ws/' + cep + '/json/', true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var endereco = JSON.parse(xhr.responseText);
                        preencherCampos(endereco);
                    }
                };
                xhr.send();
            }

            // Evento de digitação no campo CEP
            document.getElementById('".$xcep->getId()."').addEventListener('keyup', function() {
                var cep = this.value.replace(/\\D/g, '');
                if (cep.length === 8) {
                    buscarCep(cep);
                }
            });
        ";

        // Adiciona o script ao final do HTML gerado
        echo "<script>".$script."</script>";

        $row = $this->form->addFields([new TLabel('CEP:*'), $xcep]);
        $row->layout = ['col-sm-4'];

        $row = $this->form->addFields([new TLabel('Endereço:*'), $xend]);
        $row->layout = ['col-sm-4'];

        $row = $this->form->addFields([new TLabel('Número:*'), $xnum]);
        $row->layout = ['col-sm-4'];

        $row = $this->form->addFields([new TLabel('Complemento:'), $xcpl]);
        $row->layout = ['col-sm-4'];

        $row = $this->form->addFields([new TLabel('Bairro:*'), $xbai]);
        $row->layout = ['col-sm-4'];

        $row = $this->form->addFields([new TLabel('Cidade:*'), $xcid]);
        $row->layout = ['col-sm-4'];

        $row = $this->form->addFields([new TLabel('Estado:*'), $xesr]);
        $row->layout = ['col-sm-4'];

        $row = $this->form->addFields([new TLabel('Email:*'), $xema]);
        $row->layout = ['col-sm-4'];

        $row = $this->form->addFields([new TLabel('Celular:*'), $xcel]);
        $row->layout = ['col-sm-4'];

        $row = $this->form->addFields([new TLabel('Telefone:'), $xtel]);
        $row->layout = ['col-sm-4'];


        $this->form->appendPage('Estrangeiro');
        $xetg = new TCombo('egt');
        $xetgdat = new TDate('etgdat');
        $xetgdat->setMask('dd/mm/yyyy');
        $xetgnat = new TDate('etgnat');
        $xetgnat->setMask('dd/mm/yyyy');
        $xetgsit = new TCombo('etgsit');
        $xetgsit->addItems($xsim);
        $xetgfil = new TCombo('etgfil');
        $xetgfil->addItems($xsim);
        $xetg->addItems(['0' => 'Não','1' => 'Sim' ]);
        $xetg->setDefaultOption(FALSE);
        $xetgsit->addItems(['0' => 'Não','1' => 'Sim' ]);
        $xetgfil->addItems(['0' => 'Não','1' => 'Sim' ]);

        $row = $this->form->addFields([new TLabel('Estrangeiro:*'), $xetg]);
        $row->layout = ['col-sm-2'];

        $row = $this->form->addFields([new TLabel('Data de Chegada:'), $xetgdat]);
        $row->layout = ['col-sm-2'];

        $row = $this->form->addFields([new TLabel('Data Naturalização'), $xetgnat]);
        $row->layout = ['col-sm-2'];

        $row = $this->form->addFields([new TLabel('Casado(a):'), $xetgsit]);
        $row->layout = ['col-sm-2'];

        $row = $this->form->addFields([new TLabel('Filho de Brasileiro(a):'), $xetgfil]);
        $row->layout = ['col-sm-2'];

        $row = $this->form->addFields([new TLabel('Campos(*) são obrigatorios')]);
        $row->layout = ['col-sm-2'];

        //**************************************//
        //            ABA DEPENDENTES           //
        //**************************************//
        $this->form->appendPage('Dependentes');

        $subform = new BootstrapFormBuilder;
        $subform->setFieldSizes('100%');
        $subform->setProperty('style', 'border:none');

        $subform->appendPage('Dependente 1');

        $xdepnom = new TEntry('depnom');
        $xdepnom->setProperty('style', 'text-transform:uppercase');
        $xdepcpf = new TEntry('depcpf');
        $xdepcpf->setMask('999.999.999-99');
        $xdepcpf->setMaxLength(11);
        $xdepcpf->setExitAction(new TAction([$this, 'onValidaCpf']));
        $xdeppar = new TCombo('deppar');
        $xdeppar->addItems($xparent);
        $xdepnas = new TDate('depnas');
        $xdepnas->setMask('dd/mm/yyyy');
        $xdepsex = new TCombo('depsex');
        $xdepsex->addItems($xsexcombo);
        $xdepinc = new TCombo('depinc');
        $xdepinc->addItems($xsim);
        $xdepirf = new TCombo('depirf');
        $xdepirf->addItems($xsim);
        $xdepsaf = new TCombo('depsaf');
        $xdepsaf->addItems($xsim);

        $depescola_file = new TFile('pathdepescola');
        $depescola_file->enableFileHandling();
        $depescola_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depescola_file->setSize(400);
        $depescola_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depcpf_file = new TFile('pathdepcpf');
        $depcpf_file->enableFileHandling();
        $depcpf_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depcpf_file->setSize(400);
        $depcpf_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depvacina_file = new TFile('pathdepvacina');
        $depvacina_file->enableFileHandling();
        $depvacina_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depvacina_file->setSize(400);
        $depvacina_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depnascas_file = new TFile('pathdepnascas');
        $depnascas_file->enableFileHandling();
        $depnascas_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depnascas_file->setSize(400);
        $depnascas_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $deprg_file = new TFile('pathdeprg');
        $deprg_file->enableFileHandling();
        $deprg_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $deprg_file->setSize(400);
        $deprg_file->setTip('Somente arquivos JPG, JPEG e PDF');

        $row = $subform->addFields([new TLabel('Nome Dependente:'), $xdepnom]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('CPF'), $xdepcpf]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Parentesco'), $xdeppar]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Data de Nascimento:'), $xdepnas]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Gênero:'), $xdepsex]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Incapacitado:'), $xdepinc]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Dep IRRF:'), $xdepirf]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Salario Familia:'), $xdepsaf]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Escola:'), $depescola_file]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('CPF:'), $depcpf_file]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Cartão Vacina:'), $depvacina_file]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Certidão Nasc./Casam:'), $depnascas_file]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('RG:'), $deprg_file]);
        $row->layout = ['col-sm-4'];



        $subform->appendPage('Dependente 2');

        $xdepnom2 = new TEntry('depnom2');
        $xdepnom2->setProperty('style', 'text-transform:uppercase');
        $xdepcpf2 = new TEntry('depcpf2');
        $xdepcpf2->setMask('999.999.999-99');
        $xdepcpf2->setMaxLength(11);
        $xdepcpf2->setExitAction(new TAction([$this, 'onValidaCpf']));
        $xdeppar2 = new TCombo('deppar2');
        $xdeppar2->addItems($xparent); 

        $xdepnas2 = new TDate('depnas2');
        $xdepnas2->setMask('dd/mm/yyyy');
        $xdepsex2 = new TCombo('depsex2');
        $xdepsex2->addItems($xsexcombo);
        $xdepinc2 = new TCombo('depinc2');
        $xdepinc2->addItems($xsim);
        $xdepirf2 = new TCombo('depirf2');
        $xdepirf2->addItems($xsim);
        $xdepsaf2 = new TCombo('depsaf2');
        $xdepsaf2->addItems($xsim);

        $depescola2_file = new TFile('pathdepescola2');
        $depescola2_file->enableFileHandling();
        $depescola2_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depescola2_file->setSize(400);
        $depescola2_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depcpf2_file = new TFile('pathdepcpf2');
        $depcpf2_file->enableFileHandling();
        $depcpf2_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depcpf2_file->setSize(400);
        $depcpf2_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depvacina2_file = new TFile('pathdepvacina2');
        $depvacina2_file->enableFileHandling();
        $depvacina2_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depvacina2_file->setSize(400);
        $depvacina2_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depnascas2_file = new TFile('pathdepnascas2');
        $depnascas2_file->enableFileHandling();
        $depnascas2_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depnascas2_file->setSize(400);
        $depnascas2_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $deprg2_file = new TFile('pathdeprg2');
        $deprg2_file->enableFileHandling();
        $deprg2_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $deprg2_file->setSize(400);
        $deprg2_file->setTip('Somente arquivos JPG, JPEG e PDF');

        $row = $subform->addFields([new TLabel('Nome Dependente:'), $xdepnom2]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('CPF'), $xdepcpf2]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Parentesco'), $xdeppar2]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Data de Nascimento:'), $xdepnas2]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Gênero:'), $xdepsex2]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Incapacitado:'), $xdepinc2]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Dep IRRF:'), $xdepirf2]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Salario Familia:'), $xdepsaf2]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Escola:'), $depescola2_file]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('CPF:'), $depcpf2_file]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Cartão Vacina:'), $depvacina2_file]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Certidão Nasc./Casam:'), $depnascas2_file]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('RG:'), $deprg2_file]);
        $row->layout = ['col-sm-4'];


        $subform->appendPage('Dependente 3');

        $xdepnom3 = new TEntry('depnom3');
        $xdepnom3->setProperty('style', 'text-transform:uppercase');
        $xdepcpf3 = new TEntry('depcpf3');
        $xdepcpf3->setMask('999.999.999-99');
        $xdepcpf3->setMaxLength(11);
        $xdepcpf3->setExitAction(new TAction([$this, 'onValidaCpf']));
        $xdeppar3 = new TCombo('deppar3');
        $xdeppar3->addItems($xparent);
        $xdepnas3 = new TDate('depnas3');
        $xdepnas3->setMask('dd/mm/yyyy');
        $xdepsex3 = new TCombo('depsex3');
        $xdepsex3->addItems($xsexcombo);
        $xdepinc3 = new TCombo('depinc3');
        $xdepinc3->addItems($xsim);
        $xdepirf3 = new TCombo('depirf3');
        $xdepirf3->addItems($xsim);
        $xdepsaf3 = new TCombo('depsaf3');
        $xdepsaf3->addItems($xsim);

        $depescola3_file = new TFile('pathdepescola3');
        $depescola3_file->enableFileHandling();
        $depescola3_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depescola3_file->setSize(400);
        $depescola3_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depcpf3_file = new TFile('pathdepcpf3');
        $depcpf3_file->enableFileHandling();
        $depcpf3_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depcpf3_file->setSize(400);
        $depcpf3_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depvacina3_file = new TFile('pathdepvacina3');
        $depvacina3_file->enableFileHandling();
        $depvacina3_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depvacina3_file->setSize(400);
        $depvacina3_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depnascas3_file = new TFile('pathdepnascas3');
        $depnascas3_file->enableFileHandling();
        $depnascas3_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depnascas3_file->setSize(400);
        $depnascas3_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $deprg3_file = new TFile('pathdeprg3');
        $deprg3_file->enableFileHandling();
        $deprg3_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $deprg3_file->setSize(400);
        $deprg3_file->setTip('Somente arquivos JPG, JPEG e PDF');

        $row = $subform->addFields([new TLabel('Nome Dependente:'), $xdepnom3]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('CPF'), $xdepcpf3]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Parentesco'), $xdeppar3]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Data de Nascimento:'), $xdepnas3]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Gênero:'), $xdepsex3]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Incapacitado:'), $xdepinc3]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Dep IRRF:'), $xdepirf3]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Salario Familia:'), $xdepsaf3]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Escola:'), $depescola3_file]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('CPF:'), $depcpf3_file]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Cartão Vacina:'), $depvacina3_file]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Certidão Nasc./Casam:'), $depnascas3_file]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('RG:'), $deprg3_file]);
        $row->layout = ['col-sm-4'];


        $subform->appendPage('Dependente 4');

        $xdepnom4 = new TEntry('depnom4');
        $xdepnom4->setProperty('style', 'text-transform:uppercase');
        $xdepcpf4 = new TEntry('depcpf4');
        $xdepcpf4->setMask('999.999.999-99');
        $xdepcpf4->setMaxLength(11);
        $xdepcpf4->setExitAction(new TAction([$this, 'onValidaCpf']));
        $xdeppar4 = new TCombo('deppar4');
        $xdeppar4->addItems($xparent);

        $xdepnas4 = new TDate('depnas4');
        $xdepnas4->setMask('dd/mm/yyyy');
        $xdepsex4 = new TCombo('depsex4');
        $xdepsex4->addItems($xsexcombo);
        $xdepinc4 = new TCombo('depinc4');
        $xdepinc4->addItems($xsim);
        $xdepirf4 = new TCombo('depirf4');
        $xdepirf4->addItems($xsim);
        $xdepsaf4 = new TCombo('depsaf4');
        $xdepsaf4->addItems($xsim);
       
        $depescola4_file = new TFile('pathdepescola4');
        $depescola4_file->enableFileHandling();
        $depescola4_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depescola4_file->setSize(400);
        $depescola4_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depcpf4_file = new TFile('pathdepcpf4');
        $depcpf4_file->enableFileHandling();
        $depcpf4_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depcpf4_file->setSize(400);
        $depcpf4_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depvacina4_file = new TFile('pathdepvacina4');
        $depvacina4_file->enableFileHandling();
        $depvacina4_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depvacina4_file->setSize(400);
        $depvacina4_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depnascas4_file = new TFile('pathdepnascas4');
        $depnascas4_file->enableFileHandling();
        $depnascas4_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depnascas4_file->setSize(400);
        $depnascas4_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $deprg4_file = new TFile('pathdeprg4');
        $deprg4_file->enableFileHandling();
        $deprg4_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $deprg4_file->setSize(400);
        $deprg4_file->setTip('Somente arquivos JPG, JPEG e PDF');

        $row = $subform->addFields([new TLabel('Nome Dependente:'), $xdepnom4]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('CPF'), $xdepcpf4]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Parentesco'), $xdeppar4]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Data de Nascimento:'), $xdepnas4]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Gênero:'), $xdepsex4]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Incapacitado:'), $xdepinc4]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Dep IRRF:'), $xdepirf4]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Salario Familia:'), $xdepsaf4]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Escola:'), $depescola4_file]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('CPF:'), $depcpf4_file]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Cartão Vacina:'), $depvacina4_file]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Certidão Nasc./Casam:'), $depnascas4_file]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('RG:'), $deprg4_file]);
        $row->layout = ['col-sm-4'];



        $subform->appendPage('Dependente 5');

        $xdepnom5 = new TEntry('depnom5');
        $xdepnom5->setProperty('style', 'text-transform:uppercase');
        $xdepcpf5 = new TEntry('depcpf5');
        $xdepcpf5->setMask('999.999.999-99');
        $xdepcpf5->setMaxLength(11);
        $xdepcpf5->setExitAction(new TAction([$this, 'onValidaCpf']));
        $xdeppar5 = new TCombo('deppar5');
        $xdeppar5->addItems($xparent);
        $xdepnas5 = new TDate('depnas5');
        $xdepnas5->setMask('dd/mm/yyyy');
        $xdepsex5 = new TCombo('depsex5');
        $xdepsex5->addItems($xsexcombo);
        $xdepinc5 = new TCombo('depinc5');
        $xdepinc5->addItems($xsim);
        $xdepirf5 = new TCombo('depirf5');
        $xdepirf5->addItems($xsim);
        $xdepsaf5 = new TCombo('depsaf5');
        $xdepsaf5->addItems($xsim);

        $depescola5_file = new TFile('pathdepescola5');
        $depescola5_file->enableFileHandling();
        $depescola5_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depescola5_file->setSize(400);
        $depescola5_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depcpf5_file = new TFile('pathdepcpf5');
        $depcpf5_file->enableFileHandling();
        $depcpf5_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depcpf5_file->setSize(400);
        $depcpf5_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depvacina5_file = new TFile('pathdepvacina5');
        $depvacina5_file->enableFileHandling();
        $depvacina5_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depvacina5_file->setSize(400);
        $depvacina5_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $depnascas5_file = new TFile('pathdepnascas5');
        $depnascas5_file->enableFileHandling();
        $depnascas5_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $depnascas5_file->setSize(400);
        $depnascas5_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // dependentes
        $deprg5_file = new TFile('pathdeprg5');
        $deprg5_file->enableFileHandling();
        $deprg5_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $deprg5_file->setSize(400);
        $deprg5_file->setTip('Somente arquivos JPG, JPEG e PDF');

        $row = $subform->addFields([new TLabel('Nome Dependente:'), $xdepnom5]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('CPF'), $xdepcpf5]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Parentesco'), $xdeppar5]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Data de Nascimento:'), $xdepnas5]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Gênero:'), $xdepsex5]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Incapacitado:'), $xdepinc5]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Dep IRRF:'), $xdepirf5]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Salario Familia:'), $xdepsaf5]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Escola:'), $depescola5_file]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('CPF:'), $depcpf5_file]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Cartão Vacina:'), $depvacina5_file]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('Certidão Nasc./Casam:'), $depnascas5_file]);
        $row->layout = ['col-sm-4'];

        $row = $subform->addFields([new TLabel('RG:'), $deprg5_file]);
        $row->layout = ['col-sm-4'];


        $this->form->addContent( [$subform] );

        $this->form->appendPage('Informações Bancárias');

        $agencia = new TEntry('age');
        $conta = new TEntry('con');

        $unitbanx = TSession::getValue('userunitban');
        $radio_enable = new TRadioGroup('enable');
        $radio_enable->addItems(array('1'=>'Não possuo conta '.$unitbanx.':', '2'=>'Possuo conta '.$unitbanx.':'));
        $radio_enable->setLayout('vertical');
        $radio_enable->setValue(1);
        $radio_enable->setChangeAction(new TAction([$this, 'onChangeRadio']));

        $row = $this->form->addFields([$radio_enable]);
        $row->layout = ['col-sm-4'];

        $row = $this->form->addFields([new TLabel('Agência:'),$agencia]);
        $row->layout = ['col-sm-4'];

        $row = $this->form->addFields([new TLabel('Conta'), $conta]);
        $row->layout = ['col-sm-4'];
        
        
        TEntry::disableField('func_cadastro', 'age');
        TEntry::disableField('func_cadastro', 'con');

        $this->form->appendPage('VT e Fardamento');
        $xrvt = new TCombo('rvt');
        $xrvt->addItems($xsim);
        $xcan = new TCombo('can');
        $xcan->addItems($xfardacamisa);
        $xccn = new TCombo('ccn');
        $xccn->addItems($xfardacalca);
        $xsan = new TCombo('san');
        $xsan->addItems($xfardasapato);

        $row = $this->form->addFields([new TLabel('Vale Transporte:*'), $xrvt]);
        $row->layout = ['col-sm-4'];

        $row = $this->form->addFields([new TLabel('Tamanho Camisa:*'), $xcan]);
        $row->layout = ['col-sm-4'];

        $row = $this->form->addFields([new TLabel('Tamanho Calça:*'), $xccn]);
        $row->layout = ['col-sm-4'];

        $row = $this->form->addFields([new TLabel('Tamanho Sapato:*'), $xsan]);
        $row->layout = ['col-sm-4'];



        $this->form->appendPage('Termos');
        $textolgpd  = new TText('text');
        
        $textolgpd->setSize(300,300);
        $textolgpd->setvalue("
TERMO DE DEPENDENTES:

Declaro que li e estou ciente que devo apresentar à empresa os documentos necessários para obter o benefício do salário família, o qual será pago a partir do mês subsequente da apresentação da aludida documentação. Declaro ainda está ciente de que na ausência da apresentação dos documentos no prazo, o benefício será automaticamente suspenso.

• Documentos e Prazos; Declaração de frequência escolar a partir de 7 anos (semestralmente); Cartão de Vacina para menores ou igual a 7 anos (anualmente); Certidão de Nascimento.

Declaro que li e estou ciente que devo apresentar à empresa os documentos necessários para obter o benefício do salário família, o qual será pago a partir do mês subsequente da apresentação da aludida documentação. Declaro ainda está ciente de que na ausência da apresentação dos documentos no prazo, o benefício será automaticamente suspenso.


TERMO LGPD:       
Declaro, para os devidos fins, que concordo com a coleta dos meus dados pessoais para fim de conformidade com a Lei 13.709/2018 - Lei Geral de Proteção de dados, com manifestação livre, informada e inequívoca de vontade, de acordo com os termos de uso.

TERMO DO NEPOTISMO:
Declaro, para os devidos fins, que as informações proferidas na declaração de Nepotismo são verdadeiras, não havendo qualquer grau de parentesco com servidor público em atividade, e foram fornecidas com manifestação livre, informada e inequívoca de vontade, de acordo com os termos de uso.

Declaro para os devidos fins que as informações constantes neste formulário são fieis à verdade e condizentes com a realidade dos fatos à epoca.

Declaro que todas as informações mencionadas nesse formulário foram extraídas dos documentos e são de minha responsabilidade.

Por fim, fico ciente que através desse documento a falsidade das informações configura crime previsto no Código Penal Brasileiro e passível de apuração na forma da Lei.

Nada mais a declarar, e ciente das responsabilidades peças declarações prestadas, firmo a presente.
        
        ");
        
        $aceite = new TCheckButton('aceite');
        $label0 = new TLabel('Leia atentamente os Termos:');
        $label0->setFontstyle('bold');
        $label = new TLabel('Aceito os termos:');
        $label->setFontColor('red');
        $label->setFontstyle('bold');
        //$textolgpd->setFontstyle('bold');
        //$textolgpd->setvalue($label);

        $hbox = new THBox;
        $hbox->add($aceite);
        $hbox->add($label);

        

        $row = $this->form->addFields([$label0,new TLabel(' '), $textolgpd]);
        $row->layout = ['col-sm-8'];

        //$row = $this->form->addFields([new TLabel('Aceite os termos antes de finalizar:'), $aceite]);
        $row = $this->form->addFields([$hbox]);
        $row->layout = ['col-sm-8'];


        $this->form->appendPage('Anexos');

        // RG
        $rg_file = new TFile('pathrg');
        $rg_file->enableFileHandling();
        $rg_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $rg_file->setSize(300);
        $rg_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // CPF
        $cpf_file = new TFile('pathcpf');
        $cpf_file->enableFileHandling();
        $cpf_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $cpf_file->setSize(300);
        $cpf_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // Comprovante de Residência
        $res_file = new TFile('pathresidencia');
        $res_file->enableFileHandling();
        $res_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $res_file->setSize(300);
        $res_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // ELEITOR
        $eleitor_file = new TFile('patheleitor');
        $eleitor_file->enableFileHandling();
        $eleitor_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $eleitor_file->setSize(300);
        $eleitor_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // RESERVISTA
        $reserva_file = new TFile('pathreserva');
        $reserva_file->enableFileHandling();
        $reserva_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $reserva_file->setSize(300);
        $reserva_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // pis
        $pis_file = new TFile('pathpis');
        $pis_file->enableFileHandling();
        $pis_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $pis_file->setSize(300);
        $pis_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // vacina
        $vacina_file = new TFile('pathvacina');
        $vacina_file->enableFileHandling();
        $vacina_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $vacina_file->setSize(300);
        $vacina_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // nascimento ou casamento
        $nascas_file = new TFile('pathnascas');
        $nascas_file->enableFileHandling();
        $nascas_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $nascas_file->setSize(300);
        $nascas_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // escolaridade
        $escola_file = new TFile('pathescola');
        $escola_file->enableFileHandling();
        $escola_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $escola_file->setSize(300);
        $escola_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // ctps
        $ctps_file = new TFile('pathctps');
        $ctps_file->enableFileHandling();
        $ctps_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $ctps_file->setSize(300);
        $ctps_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // curriculo
        $curriculo_file = new TFile('pathcurriculo');
        $curriculo_file->enableFileHandling();
        $curriculo_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $curriculo_file->setSize(300);
        $curriculo_file->setTip('Somente arquivos JPG, JPEG e PDF');

        // Fotos
        $foto_file = new TFile('pathfoto');
        $foto_file->enableFileHandling();
        $foto_file->setAllowedExtensions(['jpg', 'jpeg', 'pdf']);
        $foto_file->setSize(300);
        $foto_file->setTip('Somente arquivos JPG, JPEG e PDF');

        $row = $this->form->addFields([new TLabel('RG:*'), $rg_file]);
        $row->layout = ['col-sm-4'];

        $row = $this->form->addFields([new TLabel('CPF:*'), $cpf_file]);
        $row->layout = ['col-sm-4'];

        $row = $this->form->addFields([new TLabel('Comprovante de residência com CEP:*'), $res_file]);
        $row->layout = ['col-sm-4'];

        $row = $this->form->addFields([new TLabel('Título de Eleitor:*'), $eleitor_file]);
        $row->layout = ['col-sm-4'];

        $row = $this->form->addFields([new TLabel('Reservista (homens):*'), $reserva_file]);
        $row->layout = ['col-sm-4'];

        $row = $this->form->addFields([new TLabel('Extrato do PIS:*'), $pis_file]);
        $row->layout = ['col-sm-4'];

        $row = $this->form->addFields([new TLabel('Cartão de Vacina:*'), $vacina_file]);
        $row->layout = ['col-sm-4'];

        $row = $this->form->addFields([new TLabel('Cert. de Nascimento ou Casamento:*'), $nascas_file]);
        $row->layout = ['col-sm-4'];

        $row = $this->form->addFields([new TLabel('Comprovante de Escolaridade:*'), $escola_file]);
        $row->layout = ['col-sm-4'];

        $row = $this->form->addFields([new TLabel('Cópia da CTPS Digital:*'), $ctps_file]);
        $row->layout = ['col-sm-4'];

        $row = $this->form->addFields([new TLabel('Currículo:*'), $curriculo_file]);
        $row->layout = ['col-sm-4'];

        $row = $this->form->addFields([new TLabel('Foto:*'), $foto_file]);
        $row->layout = ['col-sm-4'];


        /*
        
            ABA FINALIZAR
        
        */

        

        $this->form->appendPage('Finalizar');
        $aviso_final = new TLabel('Verifique todos os dados, após salvar feche a plataforma e aguarde o contato da empresa.');
        $aviso_final->setFontColor('green');
        $aviso_final->setFontstyle('bold');
        $btn_salvar = new TButton('finalizar');
        $btn_salvar->setLabel('Salvar');
        $btn_salvar->setImage('fa:save'); // ícone do Font Awesome
        $btn_salvar->class = 'btn btn-success btn-lg btn-salvar-destaque'; // adiciona classe personalizada
        $btn_salvar->style = 'margin-left: 20px; display: block; width: 120px; height: 45px;'; // centraliza e define largura

        // Define a ação ao clicar
        $btn_salvar->setAction(new TAction([$this, 'onSave']), 'Salvar');

        $row = $this->form->addFields([$aviso_final]);
        $row->layout = ['col-sm-12']; // ocupa toda a largura da aba

        $row = $this->form->addFields([$btn_salvar]);
        $row->layout = ['col-sm-12']; // ocupa toda a largura da aba


        


        
        //$this->form->addAction('Send', new TAction(array($this, 'onSend')), 'far:check-circle green');
        
        // wrap the page content using vertical box
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($this->form);

        parent::add($vbox);
    }
    
    /**
     * Post data
     */
    /*public function onSend($param)
    {
        $data = $this->form->getData();
        $this->form->setData($data);
        
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }*/



    public static function onValidaCpf($param)
    {
        try {
            $validator = new TCPFValidator;
            $validator->validate('CPF', $param['cpf']);
            //new TMessage('info', 'CPF Válido');
        } catch (Exception $e) {        
            //new TMessage('info', $e);
            //new TMessage('info', 'CPF xxxxxxxválido!');
        }

    }

    public static function isValid($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

     // Chamada quando mudar o radio
    public static function onChangeRadio($param)
    {
        
        if ($param['enable'] == '2') {

            TEntry::enableField('func_cadastro', 'con');
            TEntry::enableField('func_cadastro', 'age');

        } else {

            TEntry::disableField('func_cadastro', 'age');
            TEntry::disableField('func_cadastro', 'con');
        }
    }

    public function onSave($param)
    {
        try
        {   
            //////////////////////
        /*
            try {
                 $type = 'html';
                 Mailservice::send(['herculanobruno01@gmail.com'],'teste','hello mail');

                 new TMessage('info','Email enviado com sucesso!');
                
            } catch (Exception $e) {
                echo 'Erro ao enviar o e-mail: ' . $e->getMessage();
            }
            //////////////////////
            */
            
            TTransaction::open('teste');
            $this->form->validate();

            $data = $this->form->getData();
            $this->form->setData($data);
            
            $object = new Sipfun;
            $object->fromArray ((array)$data);

            ////////////////////////////////////

    
            
            if (empty($data->des))
            {
                throw new Exception('Preencha seu Nome');
            }
            if (($data->nac === 0))
            {
                throw new Exception('Preencha sua Nacionalidade');
            }
            if (($data->lug===0))
            {
                throw new Exception('Preencha sua Naturalidade');
            }
            if (empty($data->nas))
            {
                throw new Exception('Preencha sua Data de Nascimento');
            }
            if (($data->sex===0))
            {
                throw new Exception('Preencha seu Gênero');
            }
            if (empty($data->mae))
            {
                throw new Exception('Preencha o nome da sua Mãe');
            }
            
            
            if (empty($data->sit))
            {
                throw new Exception('Preencha seu Estado Civil');
            }
            if (($data->rac===0))
            {
                throw new Exception('Preencha sua Raça');
            }
            if (($data->def===0))
            {
                throw new Exception('Preencha o campo de deficiência');
            }


            // SEGUNDA ABA//////////////////////////////////////////
            if (empty($data->cpf))
            {
                throw new Exception('Preencha seu CPF');
            }
            
            if (empty($data->ide))
            {
                throw new Exception('Preencha seu RG');
            }

            if (empty($data->ssp))
            {
                throw new Exception('Preencha o órgão Emissor do RG');
            }
            if (empty($data->dti))
            {
                throw new Exception('Preencha a data de Emissão do RG');
            }
            
            if (($data->ins===0))
            {
                throw new Exception('Preencha a Escolaridade');
            }

            // TERCEIRA ABA////////////////////////////////////////////
            if (empty($data->cep))
            {
                throw new Exception('Preencha seu CEP');
            }

            if (empty($data->end))
            {
                throw new Exception('Preencha o endereço');
            }
            if (empty($data-> num))
            {
                throw new Exception('Preencha o numero da sua residência');
            }
            if (empty($data->bai))
            {
                throw new Exception('Preencha seu bairro');
            }
            if (empty($data->cid))
            {
                throw new Exception('Preencha sua cidade');
            }
            if (empty($data->esr))
            {
                throw new Exception('Preencha seu Estado');
            }
            if (empty($data->ema))
            {
                throw new Exception('Preencha seu Email');
            }
            if (empty($data->cel))
            {
                throw new Exception('Preencha seu Celular');
            }

            

            // setima aba/////////////////////////////
            if (($data->rvt===0))
            {
                throw new Exception('Preencha o campo de vale transporte');
            }
            if (($data->can===0))
            {
                throw new Exception('Preencha o tamanho da sua camisa');
            }
            if (($data->ccn===0))
            {
                throw new Exception('Preencha o tamanho da sua calça');
            }
            if (($data->san===0))
            {
                throw new Exception('Preencha o tamanho do seu sapato');
            }
            



            $wdat = date('Y-m-d');
            $object->cat_dat = $wdat;
            
            // transformando a data US p/ BR
            $object->nas     = TDate::date2us($object->nas);
            $object->cte     = TDate::date2us($object->cte);
            $object->dti     = TDate::date2us($object->dti);
            $object->etgdat  = TDate::date2us($object->etgdat);
            $object->etgnat  = TDate::date2us($object->etgnat);
            $object->depnas  = TDate::date2us($object->depnas);
            $object->depnas2 = TDate::date2us($object->depnas2);
            $object->depnas3 = TDate::date2us($object->depnas3);
            $object->depnas4 = TDate::date2us($object->depnas4);
            $object->depnas5 = TDate::date2us($object->depnas5);

            // transformando em maiuscula
            $object->end     = strtoupper($object->end);
            $object->cpl     = strtoupper($object->cpl);
            $object->cid     = strtoupper($object->cid);
            $object->ema     = strtoupper($object->ema);
            $object->bai     = strtoupper($object->bai);
            $object->esr     = strtoupper($object->esr);
            $object->mae     = strtoupper($object->mae);
            $object->pai     = strtoupper($object->pai);
            $object->ssp     = strtoupper($object->ssp);
            $object->gue     = strtoupper($object->gue);
            $object->des     = strtoupper($object->des);
            $object->lug     = strtoupper($object->lug);
            $object->depnom  = strtoupper($object->depnom);
            $object->depnom2 = strtoupper($object->depnom2);
            $object->depnom3 = strtoupper($object->depnom3);
            $object->depnom4 = strtoupper($object->depnom4);
            $object->depnom5 = strtoupper($object->depnom5);



            $object->store();
            //$wdat->store();
            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathrg',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathcpf',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathresidencia',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'patheleitor',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathreserva',$warq);
            
            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathpis',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathvacina',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathnascas',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathescola',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathctps',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathcurriculo',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathfoto',$warq);

            // DEPENDENTES
            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepescola',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepcpf',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepnascas',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepvacina',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdeprg',$warq);
            // dep2
            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepescola2',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepcpf2',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepnascas2',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepvacina2',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdeprg2',$warq);
            // dep3
            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepescola3',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepcpf3',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepnascas3',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepvacina3',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdeprg3',$warq);
            // dep4
            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepescola4',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepcpf4',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepnascas4',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepvacina4',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdeprg4',$warq);
            
            // dep5
            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepescola5',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepcpf5',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepnascas5',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdepvacina5',$warq);

            $warq  = 'files/documents/'.$data->emp;
            $warq .= '/'.$data->mat;
            $this->saveFile($object, $data, 'pathdeprg5',$warq);


            /*$this->saveFile($object, $data, 'pathcpf','files/documents/cpf');
            $this->saveFile($object, $data, 'pathresidencia','files/documents');*/
           

            new TMessage('info', 'Operação realizada com sucesso, sua conta foi desativada e pode sair da plataforma e aguardar o contato da empresa.');
            
            // Load another page

             // marcar usuário atual como inativo (impede novos logins)
            try {
                $current_user_id = TSession::getValue('userid');
                if (!empty($current_user_id)) {
                    TTransaction::open('permission');
                    $sysUser = new SystemUser($current_user_id);
                    if ($sysUser instanceof SystemUser) {
                        $sysUser->active = "N";
                        $sysUser->store();
                    }
                    TTransaction::close();
                }
            } catch (Exception $e) {
                // não bloquear o fluxo principal caso falhe ao desativar o usuário
                //new TMessage('error', 'Não foi possível desativar o usuário: ' . $e->getMessage());
                try { TTransaction::close(); } catch (Exception $e2) {}
            }

            // encerra sessão do usuário atual e redireciona para tela de login
            TSession::setValue('userid', null);
            TSession::setValue('login', null);
            TSession::setValue('name', null);
            TSession::setValue('userunitname', null);
            TSession::setValue('userunitid', null);


           /*SystemAccessLogService::registerLogout();
           TSession::freeSession();
           AdiantiCoreApplication::gotoPage('LoginForm', '');
          */
            TTransaction::close();
            //AdiantiCoreApplication::loadPage('SipfunForm2', 'onLoadFromForm1', (array) $data);
            
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
}
