function topMenuItem(menuItemId, menuContentID) {

    document.getElementById(menuContentID).style.display = 'none';

    let topMenuItem = document.getElementById(menuItemId);

    topMenuItem.addEventListener("mouseover", function (e) {
        if (fixedMouse(e, topMenuItem)) {

            hideAllMenuContent();

            let menuDiv = document.getElementById("top_menu_content");
            let menuContent = document.getElementById(menuContentID);
            menuDiv.style.display = "block";
            menuContent.style.display = "block";
            // log(menuDiv);
            // log(menuContent);
            log('mouseover block');
        }
        log('mouseover' + e);
        // e.preventDefault();
        // e.stopPropagation();
    }, false);

}

function topMenuClose() {
    let topMenu = document.getElementById('top_menu');

    topMenu.addEventListener('mouseout', function (e) {
        if (fixedMouse(e, topMenu)) {
            let menuDiv = document.getElementById("top_menu_content");
            // let menuContent = document.getElementById("top_menu_content_girl_clothes");
            menuDiv.style.display = "none";
            // menuContent.style.display = "none";
            log('mouseout none');
        }
        log('mouseout' + e);
    }, false);
}

function hideAllMenuContent() {
    allMenu.forEach(function (item) {
        document.getElementById(item[1]).style.display = 'none';
    });
}

function relationAllMenuAndContent() {
    allMenu.forEach(function (item) {
        topMenuItem(item[0], item[1]);
    });
}

let allMenu = [
    [
        'top_menu_content_girl_clothes_menu',
        'top_menu_content_girl_clothes'
    ],
    [
        'top_menu_content_man_clothes_menu',
        'top_menu_content_man_clothes'
    ],
    [
        'top_menu_content_shoes_menu',
        'top_menu_content_shoes'
    ],
    [
        'top_menu_content_ornament_menu',
        'top_menu_content_ornament'
    ],
    [
        'top_menu_content_sports_menu',
        'top_menu_content_sports'
    ],
    [
        'top_menu_content_tv_menu',
        'top_menu_content_tv'
    ],
    [
        'top_menu_content_home_bed_menu',
        'top_menu_content_home_bed'
    ],
    [
        'top_menu_content_phone_menu',
        'top_menu_content_phone'
    ],
    [
        'top_menu_content_car_menu',
        'top_menu_content_car'
    ],
    [
        'top_menu_content_toy_menu',
        'top_menu_content_toy'
    ],
    [
        'top_menu_content_office_menu',
        'top_menu_content_office'
    ],
    [
        'top_menu_content_face_painting_menu',
        'top_menu_content_face_painting'
    ]
];


function topMenuAll() {
    hideAllMenuContent();
    relationAllMenuAndContent();
    topMenuClose();
}

topMenuAll();


function log(txt) {
    console.log(txt);
}

//处理mouseover和mouseleave事件。防止子元素调用
function contains(p, c) {
    return p.contains ?
        p != c && p.contains(c) : !!(p.compareDocumentPosition(c) & 16);
}

function fixedMouse(e, target) {
    e = e || window.event;
    var related,
        type = e.type.toLowerCase();//这里获取事件名字
    if (type == 'mouseover') {
        related = e.relatedTarget || e.fromElement
    } else if (type = 'mouseout') {
        related = e.relatedTarget || e.toElement
    } else return true;
    return related && related.prefix != 'xul' && !contains(target, related) && related !== target;
}