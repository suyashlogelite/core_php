<?php
include_once "dbconfig.php";

$response = array(); // Initialize an empty array for the response

// Add category
if (isset($_POST['add']) && $_POST['add'] !== "") {
    $parent_category = $_POST['parent_category'];
    $category_name = $_POST['category_name'];
    $status = $_POST['status'];

    // Check if the category name already exists
    $selectCategory = "SELECT * FROM categories WHERE category_name = '$category_name'";
    $query_select_run = mysqli_query($conn, $selectCategory);

    if ($query_select_run) {
        if (mysqli_num_rows($query_select_run) > 0) {
            $response['status'] = 'error';
            $response['message'] = 'Category already exists! Please write another category name.';
        } else {
            $query_insert = "INSERT INTO categories (parent_category, category_name, status) VALUES ('$parent_category','$category_name','$status')";
            $query_insert_run = mysqli_query($conn, $query_insert);

            if ($query_insert_run) {
                $response['status'] = 'success';
                $response['message'] = 'Category Details Inserted Successfully';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Failed to Insert Category';
            }
        }
    }
} elseif (isset($_GET['id'])) { // Edit category
    $id = $_GET['id'];

    $query_edit = "SELECT child.id, parent.category_name as parent_category, child.category_name, child.created_at, child.updated_at, child.status FROM categories AS child LEFT JOIN categories AS parent ON child.parent_category = parent.id WHERE child.id=$id";

    $query_edit_run = mysqli_query($conn, $query_edit);
    if ($query_edit_run) {
        $num = mysqli_num_rows($query_edit_run);
        if ($num > 0) {
            $row_edit = mysqli_fetch_array($query_edit_run);
            $response['status'] = 'success';
            $response['data'] = $row_edit;
        } else {
            $response['status'] = 'error';
            $response['message'] = 'No Record found for editing';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to retrieve data for editing';
    }
} elseif (isset($_POST['cat_id']) && $_POST['cat_id'] !== "") { // Update category
    $id = $_POST['cat_id'];
    $updParentName = $_POST['parent_category'];
    $updCatName = $_POST['category_name'];

    $query = "UPDATE categories SET parent_category = '$updParentName', category_name = '$updCatName', updated_at = NOW() WHERE id = $id";

    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $query_1 = "SELECT child.id, parent.category_name as parent_category, child.category_name, child.created_at, child.updated_at, child.status FROM categories AS child LEFT JOIN categories AS parent ON child.parent_category = parent.id WHERE child.id=$id";

        $query_run1 = mysqli_query($conn, $query_1);
        if ($query_run1) {
            if (mysqli_num_rows($query_run1) > 0) {
                $row = mysqli_fetch_assoc($query_run1);
                $response['status'] = 'success';
                $response['data'] = $row;
            } else {
                $response['status'] = 'error';
                $response['message'] = 'No Record found for updating';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Unable to retrieve updated data';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Unable to update category';
    }
} elseif(isset($_GET['delete_id'])) { // Delete category
    $id = $_GET['delete_id'];

    $query_delete = "DELETE FROM categories WHERE id = $id";

    $query_delete_run = mysqli_query($conn, $query_delete);

    if ($query_delete_run) {
        $response['status'] = 'success';
        $response['message'] = 'Category Deleted Successfully';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to Delete Category';
    }
}

// Output the JSON response
echo json_encode($response);
?>
