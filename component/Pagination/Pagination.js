function Pagination(pagesTot) {
    let nbPage = '';
    for (let i = 1; i <= pagesTot; i++) {
        nbPage += `<li class="link ${i === 1 ? 'active' : ''}" value="${i}" onclick="changePage(${i})">
                        <a class="page-link" href="#">${i}</a>
                      </li>`;
    }

    return `
    <div class="pagination">
        <button class="btn1" onclick="backBtn()"> <img src="../assets/img/icons/arrow-icon.svg"> prev</button>
        <ul id="pagination-links">
            ${nbPage}
        </ul>
        <button class="btn2" onclick="nextBtn()"> next <img src="../assets/img/icons/arrow-icon.svg"></button>
    </div>`;
}
