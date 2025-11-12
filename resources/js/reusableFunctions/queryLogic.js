import {router} from "@inertiajs/react";

export function queryLogic(route, data, query, cancelToken, propReset) {
    if(data.q === query) return;
    if(cancelToken.current) cancelToken.current.cancel();

    return setTimeout(() => {
        router.get(route, {q: data.q}, {
            preserveState:true,
            replace:true,
            reset:[ propReset ,'query'],
            onCancelToken: (token) => cancelToken.current = token,
        })
    },500)
}
