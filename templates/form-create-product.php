<?php
/**
 * Template part for displaying the product creation form
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package rgb_test
 */

$terms = get_terms('clothes-type');

$user = wp_get_current_user();
$allowed_roles = array('editor', 'administrator');

if ( !array_intersect($allowed_roles, $user->roles) ) {
    return;
}
?>

<form class="js-form-create-product">
    <?php wp_nonce_field( 'rgb_clothes_create_product', 'rgb_clothes_create_product_nonce' ); ?>

    <div class="form-group">
        <label for="exampleInputEmail1">Name</label>
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="exampleInputPassword1">Description</label>
        <textarea name="description" class="form-control" rows="3" style="resize: none;"></textarea>
    </div>

    <div class="form-group">
        <label for="exampleFormControlFile1">Thumbnail</label>
        <input name="thumbnail" type="file" class="form-control-file">
    </div>

    <div class="form-group">
        <label for="exampleFormControlFile1">Size</label>
        <input name="size" type="number" min="0" class="form-control">
    </div>

    <div class="form-group">
        <label for="exampleFormControlFile1">Color</label>
        <input name="color" type="color" class="form-control" style="max-width: 70px">
    </div>

    <div class="form-group">
        <label for="exampleFormControlFile1">Sex</label>
        <div class="form-check form-check-inline">
            <input class="form-check-input" name="sex" type="radio" id="male" value="male">
            <label class="form-check-label" for="male">Male</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" name="sex" type="radio" id="female" value="female">
            <label class="form-check-label" for="female">Female</label>
        </div>
    </div>

    <div class="form-group">
        <label for="exampleFormControlSelect2">Clothes types</label>
        <select name="types" multiple class="form-control" id="exampleFormControlSelect2">
            <?php foreach ($terms as $term): ?>
            <option value="<?php echo $term->slug; ?>"><?php echo $term->name; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary js-btn">
        <span class="spinner-border spinner-border-sm js-btn-spinner" style="display: none" role="status" aria-hidden="true"></span>
        Submit
    </button>
</form>