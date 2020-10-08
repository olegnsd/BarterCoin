<?

$upd=30;
$statusCode = HTTP_OK;

switch ($_GET['page']) {
    case 'index':
        include('pages/index.php');
        break;
    case 'send':
        include('pages/send.php');
        break;
    case 'check':
        include('pages/check.php');
        break;
    case 'activate':
        include('pages/activate.php');
        break;
    case 'deposit':
        include('pages/deposit.php');
        break;
    case 'withdraw7':
        $upd=3;
        include('pages/withdraw7.php');
        break;
    case 'withdraw':
        $upd=3;
        include('pages/withdraw.php');
        break;
    case 'faq':
        $statusCode = HTTP_MAINTENANCE; // находится в разработке
        include('pages/faq.php');
        break;
    case 'api':
        include('pages/api.php');
        break;
    case 'create':
        include('pages/create.php');
        break;
    case 'create/save':
        include('pages/save.php');
        break;
    case 'loan':
        include('pages/loan.php');
        break;
    case 'referals':
        include('pages/referals.php');
        break;
    case 'restore':
        include('pages/restore.php');
        break;
    case 'pay_card':
        include('pages/pay_card.php');
        break;
    case 'pay_phone':
        include('pages/pay_phone.php');
        break;
    case 'activate2':
        include('pages/activate.php');
        break;
    case 'save_card':
        include 'pages/save_card.php';
        break;
    case 'delete_save':
        include 'pages/delete_save.php';
        break;
    // case 'test_server':
    //     include('pages/test_server.php');
    //     break;
    default:
        $statusCode = HTTP_NOT_FOUND;
        break;
}

return [ $statusCode, $upd ];
