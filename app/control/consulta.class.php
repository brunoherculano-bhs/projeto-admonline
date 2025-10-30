<?php

class consulta extends TPage
{
    private $form;
    private $datagrid;
    private $loaded;

    public function __construct()
    {
        parent::__construct();


        $this->form = new BootstrapFormBuilder('form_search_sipfun');
        $this->form->setFormTitle('Funcionários');

        $empresa = new TCombo('empresa');
        $xsit = new TCombo('status');


        TTransaction::open('permission');
        $empresas = SystemUnit::getIndexedArray('id', 'name');
        TTransaction::close();

        $empresa->addItems($empresas);
        $empresa->setValue(TSession::getValue('empresa_filter'));

        $xsit->addItems(['101' => 'Em aberto','201' => 'Admitido']);
        $xsit->setSize(200);
        $empresa->setSize(200);

        /*
        $empresa->addItems(['001' => 'Empresa 001', '002' => 'Empresa 002', '003' => 'Empresa 003']);
        $empresa->setValue(TSession::getValue('empresa_filter'));
        */

        $this->form->addFields([new TLabel('Empresa')], [$empresa]);

        $this->form->addFields([new TLabel('Situação')], [$xsit]);

        
        $this->form->addAction('Buscar', new TAction([$this, 'onSearch']), 'fa:search');

        
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->setHeight(320);

        //$this->datagrid->addColumn(new TDataGridColumn('id', 'ID', 'center', '10%'));
        
        //$this->datagrid->addColumn(new TDataGridColumn('cpf ', 'cpf', 'left', '300%'));
        $this->datagrid->addColumn(new TDataGridColumn('emp', 'Empresa', 'left', '5%'));
        $mat = new TDataGridColumn('mat', 'Matricula', 'left', '10%');
        $this->datagrid->addColumn($mat);
        $this->datagrid->addColumn(new TDataGridColumn('des', 'Nome', 'left', '20%'));
        $this->datagrid->addColumn(new TDataGridColumn('cpf', 'CPF', 'left', '15%'));
        $this->datagrid->addColumn(new TDataGridColumn('end', 'Endereço', 'left', '20%'));
        $this->datagrid->addColumn(new TDataGridColumn('ema', 'Email', 'left', '20%'));
        $this->datagrid->addColumn(new TDataGridColumn('status', 'Status', 'left', '30%'));
        

        $action = new TDataGridAction([$this, 'onViewDocuments'], ['id'=>'{id}', 'mat' => '{mat}','emp' => '{emp}']);
        $action->setLabel('Ver Documentos');
        $action->setImage('fa:folder-open');
        $this->datagrid->addAction($action);
        

        $this->datagrid->createModel();

       
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add($this->form);
        $vbox->add($this->datagrid);

        parent::add($vbox);
    }
    
    public function onViewDocuments($param)
{



    $id = $param['id'];
    $mat = $param['mat'];
    $emp = $param['emp'];

        // print_r($param['key']);
    //$wmat = $param['des'];
    //new TMessage('info',$wmat);
    //$folderPath = "files/documents/{$id}";
    //$folderPath = "files/documents/001/00008/rg/37";
    $folderPath = "files/documents/$emp"."/"."$mat"."/"."$id";
    //new TMessage('info',$folderPath);
    $items = [];

    if (file_exists($folderPath)) {
        foreach (scandir($folderPath) as $file) {
            if (!in_array($file, ['.', '..'])) {
                $items[] = [
                    'name' => $file,
                    'path' => "{$folderPath}/{$file}"
                ];
            }
        }
    } else {
        new TMessage('info', 'Nenhum arquivo encontrado');
        return;
    }

    $form = new BootstrapFormBuilder("form_documents");
    $form->setFormTitle("Documentos do Registro {$mat}");

    foreach ($items as $item) {
        $link = new TElement('a');
        $link->href = $item['path'];
        $link->target = '_blank';
        $link->add($item['name']);
        $form->addContent([$link, new TElement('br')]);
    }

    // cria a janela e força o script de exibição
    $window = TWindow::create('Verifique os documentos desse funcionario:' , 700, 500);
    $window->add($form);
    //TScript::create("__adianti_open_window('{$window->id}');");
    $window->show();
}


    public function onSearch()
    {
        $data = $this->form->getData();
        TSession::setValue('empresa_filter', $data->empresa);
        TSession::setValue('situacao_filter', $data->status);
        $this->form->setData($data);

        $this->onReload();
    }

    public function onReload($param = NULL)
    {
        $this->datagrid->clear();

        TTransaction::open('teste');

        $repository = new TRepository('Sipfun');
        $criteria = new TCriteria;

        $empresa = TSession::getValue('empresa_filter');
        if (!empty($empresa)) {
            $criteria->add(new TFilter('CAST(emp AS UNSIGNED)', '=', $empresa));
            
        }

        $xsit = TSession::getValue('situacao_filter'); // valor do combo salvo na sessão
        //new TMessage('info',$xsit);
        if (!empty($xsit) && $xsit != 0) { 
            // só aplica filtro se for diferente de "Todos"
            $criteria->add(new TFilter('status', '=', $xsit));
        }
        
        $objects = $repository->load($criteria);

        foreach ($objects as $obj) {

            
            if ($obj->status == '201') {
               $obj->status = 'Admitido';
            } elseif ($obj->status == '101') {
               $obj->status = 'Em Aberto';
            } elseif ($obj->status == '') {
               $obj->status = 'Em Aberto';
            }
            
            

            $this->datagrid->addItem($obj);
        }

        TTransaction::close();
        $this->loaded = true;
    }

    public function show()
    {
        if (!$this->loaded) {
            $this->onReload();
        }
        parent::show();
    }
}
