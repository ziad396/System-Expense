<?php
include 'function/connect.php';
include ('function/sidbar.php');
include ('function/navbar.php');
require ('expenses/all_expense.php');
$expense = new Expense();
$expenseData = $expense->getByUserId($_SESSION['id']);
$expenseCount = count($expenseData);
$countCat=$expense->numCategory($_SESSION['id']);
// ['categories_count']
// print_r($countCat);
// exit();
$sum=$expense->sumExpenses();
?>


<!-- Dashboard -->
                <section class="view active" id="view-dashboard">
                    <div class="stats-grid">
                        <article class="stat-card">
                            <span class="stat-label">Total Expenses</span>
                            <strong class="stat-value" id="statTotal"><?= $expenseCount ?></strong>
                            <span class="stat-meta">All time</span>
                        </article>
                    
                        <article class="stat-card">
                            <span class="stat-label">Average Expense</span>
                            <strong class="stat-value" id="statAverage"><?php
                            if($expenseCount>0){
                                $average=$sum/$expenseCount;
                                echo $average;
                            }
                            else {
                                echo "0.0";
                            }
                            ?></strong>
                            <span class="stat-meta">Per transaction</span>
                        </article>
                        <article class="stat-card">
                            <span class="stat-label">Categories Used</span>
                            <strong class="stat-value" id="statCategories"><?= $countCat['categories_count'] ?></strong>
                            <span class="stat-meta">Active categories</span>
                        </article>
                    </div>

                    <div class="dashboard-grid">
                        <article class="panel">
                            <div class="panel-header">
                                <h2>Spending by Category</h2>
                            </div>
                            <div class="category-bars" id="categoryBars">
                                <p class="empty-state">No expenses yet. Add your first expense to see a breakdown.</p>
                            </div>
                        </article>

                        <article class="panel">
                            <div class="panel-header">
                                <h2>Recent Expenses</h2>
                                <button class="link-btn" data-view-link="expenses">View all</button>
                            </div>
                            <div class="recent-list" id="recentList">
                                <p class="empty-state">No recent expenses.</p>
                            </div>
                        </article>
                    </div>
                </section>