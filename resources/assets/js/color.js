export default (percentage) => {
    const percentColors = [
        { pct: 0.0, color: { r: 255, g: 109, b: 109 } },
        { pct: 0.25, color: { r: 255, g: 109, b: 109 } },
        { pct: 0.5, color: { r: 255, g: 162, b: 123 } },
        { pct: 0.75, color: { r: 255, g: 208, b: 120 } },
        { pct: 1.0, color: { r: 36, g: 180, b: 126 } }
    ];

    for (var i = 1; i < percentColors.length - 1; i++) {
        if (percentage < percentColors[i].pct) {
            break;
        }
    }

    let lower = percentColors[i - 1];
    let upper = percentColors[i];
    let range = upper.pct - lower.pct;
    let rangePct = (percentage - lower.pct) / range;
    let pctLower = 1 - rangePct;
    let pctUpper = rangePct;

    let color = {
        r: Math.floor(lower.color.r * pctLower + upper.color.r * pctUpper),
        g: Math.floor(lower.color.g * pctLower + upper.color.g * pctUpper),
        b: Math.floor(lower.color.b * pctLower + upper.color.b * pctUpper)
    };

    return `rgb(${[color.r, color.g, color.b].join(',')})`;
}
