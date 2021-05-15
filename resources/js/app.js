require('./bootstrap');

require('alpinejs');

import {decode} from "blurhash";

window.decodeBlurHash = function (uuid, hash) {
    const pixels = decode(hash, 150, 150);

    const container = document.getElementById(uuid)
    const canvas    = document.createElement("canvas");
    canvas.setAttribute('height', '150')
    canvas.setAttribute('width', '150')
    const ctx       = canvas.getContext("2d");
    const imageData = ctx.createImageData(150, 150);
    imageData.data.set(pixels);
    ctx.putImageData(imageData, 0, 0);

    container.append(canvas)
}
