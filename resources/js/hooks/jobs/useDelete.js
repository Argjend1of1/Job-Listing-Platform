import {router, usePage} from "@inertiajs/react";
import {useCallback, useState} from "react";
import {confirmAction} from "@/reusableFunctions/confirmAction.js";
import {showError, showSuccess} from "@/reusableFunctions/alertUser.js";

export function useDelete () {
    const {auth} = usePage().props
    const {user} = auth;
    const [loadingDelete, setLoading] = useState(false)

    const deleteJob = useCallback( async (job) => {
        const confirm = await confirmAction(
            'Are you sure you want to remove this job ? ',
            'Yes, I am sure!'
        );
        if(!confirm) return;
        setLoading(true)

        router.delete(`/jobs/${job.id}/destroy`, {
            onSuccess: async (page) => {
                const {flash} = page.props;
                if (flash.completed) {
                    showSuccess(flash.completed, 3000)
                }

                setLoading(false)
            },
            onError: async (page) => {
                const {flash} = page.props
                if(flash.error) {
                    showError(flash.error, 3000)
                }

                setLoading(false)
            }

        })
    }, [user])

    return {deleteJob, loadingDelete}
}
