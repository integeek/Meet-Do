function Pagination(){
    return `
    <div class="pagination">
        <button class="btn1" onclick="backBtn()"> <img src="../assets/img/icons/arrow-icon.svg">prev</button>
        <ul>
            <li class="link active" value="1" onclick="activeLink()">1</li>
            <li class="link" value="2" onclick="activeLink()">2</li>
            <li class="link" value="3" onclick="activeLink()">3</li>
            <li class="link" value="4" onclick="activeLink()">4</li>
            <li class="link" value="5" onclick="activeLink()">5</li>
            <li class="link" value="6" onclick="activeLink()">6</li>
        </ul>
        <button class="btn2" onclick="nextBtn()"> next<img src="../assets/img/icons/arrow-icon.svg"></button>
    </div>
    `
}