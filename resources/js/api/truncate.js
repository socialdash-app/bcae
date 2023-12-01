export default function (sentence, limit, postfix = '...') {
    return sentence.substring(0, limit) + postfix;
}
