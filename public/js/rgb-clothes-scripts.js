(function() {
    const forms = document.getElementsByClassName("js-form-create-product");

    for (const form of forms) {
        form.addEventListener("submit", function(e) {
            e.preventDefault();
            sendFormData(form);
        });
    }

    function sendFormData(form) {

        const formData = new FormData(form);

        formData.append('action', 'rgb_clothes_create_item');
        formData.append('name', '');

        /* Set multiple selects value */
        const selectFields = form.querySelectorAll('select[multiple]');
        for (const field of selectFields) {
            formData.set(field.name, getSelectedValue(field));
        }

        setLoading(form, true);

        fetch(rgbClothesAjax.url, {
            method: 'POST',
            body: formData
        })
            .then(r => r.json())
            .then(r => {
                if (!r.success) {
                    alert(r.data.message);
                    return;
                }

                form.reset();
                alert('Product has succesfully created')
                console.log('success', r);
            })
            .catch(err => {
                console.log('err', err);
                alert('Something went wrong')
            })
            .finally(() => {
                setLoading(form, false);
            });
    }

    function getSelectedValue(select) {
        if (!select.selectedOptions.length) {
            return "";
        }

        let selectedItems = [];
        for (const option of select.selectedOptions) {
            selectedItems.push(option.value);
        }

        return selectedItems;
    }


    function setLoading(form, status) {
        form.style.pointerEvents = status ? 'none' : 'all';
        form.querySelector('.js-btn').disabled = status;
        form.querySelector('.js-btn-spinner').style.display = status ? 'inline-block' : 'none';
    }

    function showMessage() {

    }

}());