
export async function getRequest(path) {
    return await fetch(path,{
        method: 'GET',
        credentials: 'include',
        headers: {
            'Accept': 'application/json'
        },
    });
}

export async function postRequest(path, xsrfToken, data) {
    return await fetch(path, {
        method: 'POST',
        credentials: 'include',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-XSRF-TOKEN': xsrfToken
        },
        body: JSON.stringify(data)
    });
}

export async function patchRoleRequest(path, xsrfToken, role) {
    return await fetch(path, {
        method: "PATCH",
        credentials: 'include',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-XSRF-TOKEN': xsrfToken
        },
        body: JSON.stringify({
            role: role
        })
    });
}

export async function patchRequest(path, xsrfToken, data) {
    return await fetch(
        path, {
            method: 'PATCH',
            credentials: 'include',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-XSRF-TOKEN': xsrfToken
            },
            body: JSON.stringify(data),
        });
}

export async function deleteRequest(path, xsrfToken) {
    return await fetch(path, {
        method: 'DELETE',
        credentials:'include',
        headers: {
            'Accept': 'application/json',
            'X-XSRF-TOKEN': xsrfToken
        }
    })
}
