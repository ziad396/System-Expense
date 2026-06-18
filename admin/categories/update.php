<?php
require_once "../category/category.php";
$categories=new Category();
$category=$categories->getById($_GET['id'])


?>
            <main class="content admin-content">
    <section class="view active" id="view-categories">

        <article class="panel">
            <div class="panel-header">
                <div>
                    <h2>Add Category</h2>
                    <p class="admin-subtitle">
                        Create a new expense category for your tracker.
                    </p>
                </div>
            </div>

            <div class="alert-error" id="adminCategoryError">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span id="adminCategoryErrorText">
                    Category name is required.
                </span>
            </div>

            <div class="alert-success" id="adminCategorySuccess">
                <i class="fa-solid fa-circle-check"></i>
                <span>Category added successfully.</span>
            </div>

            <form action="categories/do_edit.php?id=<?=$category['id']?>" method="post">
                <div class="form-group mb-3">
                    <label class="form-label">Category name</label>
                    <input
                        type="text"
                        class="form-control-custom"
                        id="newCategoryName"
                        placeholder="e.g. Utilities"
                        name="name"
                        value="<?=$category['name']?>"
                    />
                </div>

                <button class="btn btn-primary" id="addCategoryBtn">
                    <i class="fa-solid fa-tags me-2"></i>
                    Update Category
                </button>
            </form>
        </article>

        <article class="panel mt-4">
            <h2>Expense Categories</h2>
            <ul class="admin-list" id="categoryList"></ul>
        </article>

    </section>
</main>