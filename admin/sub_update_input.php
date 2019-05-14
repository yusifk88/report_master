<?php
include_once './objts/config.php';
include_once './objts/subjects.php';

$type = $_GET['type'];
$name = $_GET['name'];
$sub = new Subjects();

?>
<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
    <form>

        <label class="control-label" for="subname">Subject Name</label>
        <input id="name" class="form-control" value="<?php echo $name; ?>" type="text" placeholder="Enter class name"
               required="required"/>
        <label class="control-label" for="type">Type</label>
        <select class="form-control" id="type">

            <?php


            if ($type === "Core Subject") {


                ?>

                <option selected="selected">Core Subject</option>

                <option>Elective Subject</option>
                <?php
            } else { ?>

                <option>Core Subject</option>
                <option selected="selected">Elective Subject</option>
                <?php
            }
            ?>


        </select>


    </form>


</div>
