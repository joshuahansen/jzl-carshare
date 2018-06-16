<section class='bg-primary'>
    <div class='container'>
        <div class='row'>
            <div class='col-lg-3'></div>
            <div class='col-lg-6 text-center'>
            <div class='confirmation'>
            <?php
                require_once('database/databaseController.php');
                require_once('controller/UserController.php');

                $userController = UserController::getInstance();
                $dbController = DatabaseController::getInstance();
                
                $currentUser = $userController->getCurrentUser();
                $credit = $currentUser->getCredit();

                $addAmount = floatval($_POST['amount']);
                
                $total = $credit + $addAmount;
                $currentUser->setCredit($total);
                $_SESSION["currentUser"] = serialize($currentUser);
                
                $creditUpdated = $dbController->updateCredit($currentUser->getUsername(), $total);
                
                if($creditUpdated)
                {
                ?>
                    <h2>Credit Added</h2>
                    <p>The amount of $<?php echo $addAmount;?> was added to your account.</p>
                    <p>You now have a total of $<?php echo $total;?></p>
                <?php 
                }
                else
                {
                ?>
                    <h2>Error Credit Not Added</h2>
                    <p>There was an error adding credit to your account.</p>
                    <p>Please return to the dashboard and try again</p>
                <?php
                }
            ?>
            </div>
            </div>
            <div class='col-lg-3'></div>
        </div>
        <div class='row'>
            <div class='col-lg-3'></div>
            <div class='col-lg-6 text-center'>
                <a class='btn btn-primary' href='dashboard'>Return to Dashboard</a>
            </div>
        <div class='col-lg-3'></div>
    </div>
</section>
