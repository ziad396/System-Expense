<?php

include ('function/sidbar.php');
include ('function/navbar.php');
require ('expenses/all_expense.php');
require ('category/category.php');

if(isset($_GET['method']) && $_GET['method'] === 'insert')
{
    include("expenses/insert.php");
    exit();
}
    elseif(isset($_GET['method']) && $_GET['method'] === 'update')
    {
        include("expenses/update.php");
        exit();
    }

$category = new Category();
$expense  = new Expense();

$search = '';
$categoryFilter = '';

    if(isset($_GET['search']))
    {
        $search = $_GET['search'];
    }

        if(isset($_GET['category']))
        {
            $categoryFilter = $_GET['category'];
        }

    if($search != '' || $categoryFilter != '')
    {
        $expenseData = $expense->filter($search, $categoryFilter);
    }
else
{
    $expenseData = $expense->getByUserId($_SESSION['id']);
}

?>

<main class="content">

    <section class="view active" id="view-expenses">

        <article class="panel">

            <div class="panel-header">
                <h2>All Expenses</h2>
                <span class="badge">
                    <?php
                    //  count($expenseData);
                     ?> items
                </span>
            </div>

            <form action="" method="GET" class="filters">

                <div class="filter-input-group">

                    <input
                        type="search"
                        name="search"
                        placeholder="Search title..."
                        class="filter-input"
                        value="<?= $search ?>"
                    >

                    <button type="submit" class="btn btn-primary btn-sm">
                        Filter
                    </button>

                </div>

                <select name="category" class="filter-input">

                    <option value="">All Categories</option>

                    <?php

                    $cats = $category->getAll();

                    foreach($cats as $cat){
                        $selected = '';

                        if($category == $cat['id']){
                            $selected = 'selected';
                        }

                        ?>

                        <option
                            value="<?= $cat['id'] ?>"
                            <?= $selected ?>
                        >
                            <?= $cat['name'] ?>
                        </option>

                        <?php
                    }

                    ?>

                </select>

                <a href="expense.php" class="btn btn-outline btn-sm">
                    Clear Filters
                </a>

            </form>

            <div class="table-wrap">

                <table class="expense-table">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php

                       if(!empty($expenseData))
{
    foreach($expenseData as $data)
    {
?>
        <tr>
            <td><?= $data['id'] ?></td>
            <td><?= $data['title'] ?></td>
            <td><?= $category->getById($data['id_category'])['name'] ?></td>
            <td><?= $data['amount'] ?></td>
            <td><?= date('Y-m-d', strtotime($data['date'])) ?></td>
            <td>
                <a href="?method=update&id=<?= $data['id'] ?>" class="btn btn-primary btn-sm">
                    Update
                </a>

                <a href="expenses/delete.php?id=<?= $data['id'] ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Are you sure?')">
                    Delete
                </a>
            </td>
        </tr>
<?php
    }
}
else
{
?>
    <tr>
        <td colspan="6" style="text-align:center">
            No expenses found
        </td>
    </tr>
<?php
}?>
                    </tbody>

                </table>

            </div>

        </article>

        

    </section>

</main>