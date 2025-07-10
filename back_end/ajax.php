<?php
require_once('includes/load.php');
if (!$session->isUserLoggedIn(true)) {
    redirect('login_v2.php', false);
}

$html = '';


if (isset($_POST['product_name']) && strlen($_POST['product_name'])) {
    $products = find_product_by_title($_POST['product_name']);

    if ($products) {
        foreach ($products as $product) {
            $product_name = remove_junk($product['name']);
            $html .= "<li class=\"list-group-item\">{$product_name}</li>";
        }
    } else {
        $html .= "<li class=\"list-group-item\">Not found</li>";
    }

    echo json_encode($html);
    exit;
}


if (isset($_POST['p_name']) && strlen($_POST['p_name'])) {
    $product_title = remove_junk($db->escape($_POST['p_name']));
    $results = find_all_product_info_by_title($product_title);

    if ($results) {
        foreach ($results as $result) {
            $id = (int)$result['id'];
            $name = remove_junk($result['name']);
            $price = remove_junk($result['sale_price']);

            $html .= "<tr>";
            $html .= "<td id=\"s_name\">{$name}</td>";
            $html .= "<input type=\"hidden\" name=\"s_id\" value=\"{$id}\">";
            $html .= "<td><input type=\"text\" class=\"form-control\" name=\"price\" value=\"{$price}\"></td>";
            $html .= "<td id=\"s_qty\"><input type=\"text\" class=\"form-control\" name=\"quantity\" value=\"1\"></td>";
            $html .= "<td><input type=\"text\" class=\"form-control\" name=\"total\" value=\"{$price}\"></td>";
            $html .= "<td><input type=\"date\" class=\"form-control datePicker\" name=\"date\" data-date-format=\"yyyy-mm-dd\"></td>";
            $html .= "<td><button type=\"submit\" name=\"add_sale\" class=\"btn btn-primary\">Add sale</button></td>";
            $html .= "</tr>";
        }
    } else {
        $html = '<tr><td colspan="6">Product name not registered in the database</td></tr>';
    }

    echo json_encode($html);
    exit;
}
?>
