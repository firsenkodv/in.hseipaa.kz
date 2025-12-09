export function scrf() {
    /** получаем csrf **/
    const metaElements = document.querySelectorAll('meta[name="csrf-token"]');
    return  metaElements.length > 0 ? metaElements[0].content : "";
    /** получаем csrf **/
}
