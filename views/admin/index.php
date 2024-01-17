<?php
/** @var yii\web\View $this */
use yii\helpers\Html;
?>
 <?php
        $session = Yii::$app->session;
        $success = $session->getFlash('successMessage');

        if(isset($success))
        {
            echo "<div class='alert alert-success' role='alert'>$success</div>";
        }
    ?>
<div class="main-div" style="display: flex;justify-content: space-between;">

    <h1>Users</h1>
    <div class="button-div">
       <?= Html::a('Add manager', ['admin/manager-register'], ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <!-- Add more columns as needed -->
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user->id ?></td>
                <td><?= $user->name ?></td>
                <td><?= $user->email ?></td>
                <td><?= ucfirst($user->role) ?></td>
                <!-- Add more cells for additional columns -->
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>