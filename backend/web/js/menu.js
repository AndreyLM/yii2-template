(function () {
    const TYPE_ITEM_TABLE_OF_CONTENT = '3';
    const TYPE_ITEM_BLOG_ARTICLES = '4';
    const TYPE_ITEM_ARTICLE = '6';

    var $relation = $('#item-relation');
    var $itemType = $('#item-type');
    var $relationField = $('.field-item-relation').hide();

    var $catFormGroup;

    $relation.attr('disabled', true);

    $itemType.on('change', function () {
        processChangeDDL(this);
    });

    function processChangeDDL(el) {
        $el = $(el);
        clearFormControls();
        $relationField.show();

        switch($el.val()) {
            case TYPE_ITEM_ARTICLE :
                itemArticle();
                break;
            case TYPE_ITEM_BLOG_ARTICLES :
                itemBlog();
                break;
            case TYPE_ITEM_TABLE_OF_CONTENT :
                itemBlog();
                break;
            default:
                $relationField.hide();
                break;

        }

    }

    function itemArticle() {
        $relation.attr('disabled', false);
        createCategoriesLoadArticles();
        $(document).on('change', '#category-list-ddl', function () {
            getArticles();
        })
    }

    function itemBlog() {
        $relation.attr('disabled', false);
        $.ajax({
            url: 'http://localhost/knowledge/backend/web/index.php?r=category%2Fajax-categories',
            method: 'GET',
            dataType: 'JSON'
        }).done(function (data) {
            for(var i = 0; i<data.length; i++)
            {
                $('<option>', {
                    value : data[i].id,
                    text: data[i].title }).appendTo($relation);
            }
        });
    }

    function getArticles() {
        var $categoryId = $('#category-list-ddl').val();

        $relation.attr('disabled', false);
        $relation.html('');
        $.ajax({
            url: 'http://localhost/knowledge/backend/web/index.php?r=article%2Fajax-articles&categoryId=' +
                $categoryId,
            method: 'GET',
            dataType: 'JSON'
        }).done(function (data) {
            for(var i = 0; i<data.length; i++)
            {
                $('<option>', {
                    value : data[i].id,
                    text: data[i].title }).appendTo($relation);
            }
        });

    }

    function createCategoriesLoadArticles() {
        $catFormGroup = $('<div>', {
            class: "form-group" }).insertBefore($('.field-item-relation'));
        $('<label>', {
            id : "category-list-label",
            for: "category-list-ddl",
            text: "Category" }).appendTo($catFormGroup);
        var $cat_ddl = $('<select>', {
            id : "category-list-ddl",
            class : "form-control",
            name : "category-list-ddl"}).appendTo($catFormGroup);

        $.ajax({
            url: 'http://localhost/knowledge/backend/web/index.php?r=category%2Fajax-categories',
            method: 'GET',
            dataType: 'JSON'
        }).done(function (data) {
            for(var i = 0; i<data.length; i++)
            {
                $('<option>', {
                    value : data[i].id,
                    text: data[i].title }).appendTo($cat_ddl);
            }
            getArticles();
        });
    }

    function clearFormControls() {
        $relation.attr('disabled', true);
        $relation.html('');

        if($catFormGroup) {
            $catFormGroup.remove();
        }
    }

})();