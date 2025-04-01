function updateComment() {
    console.log('здесь нужно получить полную информацию с бэка и впихнуть в попап. Удачи');
    openPopup();
}
function showAll(id) {
    $(`#popup-comment${id}`).removeClass('no-display');
}

function showReviewUpdateForm(id) {
    $(`#review-update${id}`).removeClass('no-display');
}

function updateSort(route) {
    window.location.href = `${route}`;
}