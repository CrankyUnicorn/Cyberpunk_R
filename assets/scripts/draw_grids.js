"use strict";
const draw_grids = (ctx, imgs) => {
    const initialData = window.__INITIAL_DATA__;
    const canvas_w = initialData.canvas_w;
    const canvas_h = initialData.canvas_h;
    var r = 0;
    var img = imgs[r];
    let j = 0;
    let i = 0;
    while (true) {
        r = Math.floor(Math.sqrt(Math.random() * 9));
        img = imgs[2 - r];
        if (((i + 1) % 7) == 0) {
            i = 0;
            j++;
        }
        if (j > 3) {
            break;
        }
        ctx.lineWidth = 2;
        ctx.strokeStyle = '#045';
        ctx.strokeRect(1, 1, canvas_w - 2, canvas_h - 2);
        ctx.strokeRect(i * img.width, j * img.height, img.width, img.height);
        ctx.drawImage(img, i * img.width, j * img.height, img.width, img.height);
        i++;
    }
};
