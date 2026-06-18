

 <!-- Add / Edit Expense -->
  <?php
  require_once "../expenses/all_expense.php";
  $expense = new Expense();
    $data = $expense->getById($_GET['id']);


  ?>
                <section  id="view-add">
                    <article class="panel form-panel">
                        <div class="panel-header">
                            <h2 id="formTitle">Add New Expense</h2>
                            <p id="formDesc">Fill in the details below to record a new expense.</p>
                        </div>

                        <form class="expense-form" id="expenseForm" action="expenses/do_edit.php?id=<?= $_GET['id'] ?>" method="post">
                            <input type="hidden" id="expenseId">

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" id="title" placeholder="e.g. Grocery shopping" name="title" value="<?= $data['title']  ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="amount">Amount ($)</label>
                                    <input type="number" id="amount" min="0.01" step="0.01" placeholder="0.00" name="amount" value="<?= $data['amount']  ?>" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select id="category" name="category" required>
                                             <?php
                                    $category=new Category();
                                   $categories= $category->getAll();
                                    foreach($categories as $item){
                                        ?>
                                        <option value="<?=$item['id']?>" <?php
                                        if(isset($data['id_category']) && $data['id_category'] == $item['id']){
                                            echo 'selected';
                                        }
                                         ?>>
                                        <?=$item['name']?></option>
                                              <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="date" id="date" name="date" value="<?= $data['date'] ?>" required>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary" id="submitBtn">Save Expense</button>
                                <button type="button" class="btn btn-outline" id="cancelEdit" hidden><a href=""></a> Cancel Edit</button>
                            </div>
                        </form>
                    </article>
                </section>