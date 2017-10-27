if ($params['type'] == 'flowtype' || $params['type'] == '') {
$flowtype_list =FlowServer::getFlowType(array());
if ($flowtype_list['code'] == 0) {
$list['flowtype'] = $flowtype_list['data'];
}
}