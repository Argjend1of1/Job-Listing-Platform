import {useCallback, useState} from "react";
import {router, usePage} from "@inertiajs/react";
import {confirmAction} from "@/reusableFunctions/confirmAction.js";
import {showInfo, showSuccess} from "@/reusableFunctions/alertUser.js";

export function useReport (job) {
    const {auth} = usePage().props;
    const {user} = auth
    const [loadingReport, setLoading] = useState(false);

    const reportJob = useCallback(async (job) => {
        const confirmation = await confirmAction(
            'Are you sure you want to report this job ?',
            'Yes, I am sure!'
        );
        if(!confirmation) return;
        setLoading(true)

        router.post(`/jobs/${job.id}/report`, {}, {
            preserveScroll: true,
            onSuccess: (page) => {
                const {flash} = page.props;

                if(flash.completed) {
                    showSuccess(flash.completed, 3000)
                }

                if(flash.message) {
                    showInfo(flash.message)
                }

                setLoading(false)
            }
        })
    }, [user])

    return {reportJob, loadingReport}
}
