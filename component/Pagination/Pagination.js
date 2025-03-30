function Pagination(){
    return `
    <div class="pagination">
            <button class="btn1" onclick="backBtn()"> <img src="../assets/img/icons/arrow-icon.svg">prev</button>
            <ul>
                <li class="link active" value="1" onclick="activeLink()"><a class="page-link" href="#">1</a></li>
                <li class="link" value="2" onclick="activeLink()"><a class="page-link" href="">2</a></li>
                <li class="link" value="3" onclick="activeLink()"><a class="page-link" href="">3</a></li>
                <li class="link" value="4" onclick="activeLink()"><a class="page-link" href="">4</a></li>
                <li class="link" value="5" onclick="activeLink()"><a class="page-link" href="">5</a></li>
                <li class="link" value="6" onclick="activeLink()"><a class="page-link" href="">6</a></li>
            </ul>
            <button class="btn2" onclick="nextBtn()"> next<img src="../assets/img/icons/arrow-icon.svg"></button>
        </div>
    `
}