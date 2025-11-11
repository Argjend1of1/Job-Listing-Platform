import {router, usePage} from "@inertiajs/react";
import {showError, showInfo, showSuccess, showWarning} from "@/reusableFunctions/alertUser.js";
import {useCallback, useState} from "react";
import {confirmAction} from "@/reusableFunctions/confirmAction.js";

export function useApplication() {
    const {auth} = usePage().props;
    const {user} = auth;
    const [loadingApply, setLoading] = useState(false);

    const applyForJob = useCallback(async (job) => {
        if (!user) {
            const loginWarning = await showWarning(
                "Please log in first.",
                "You need to be logged in to apply for this job.",
                "Login"
            );

            if(!loginWarning) return;
        }

        const confirmation = await confirmAction(
            'Are you sure you want to apply for this job ?',
            'Yes, I am sure!'
        )
        if(!confirmation) return;

        setLoading(true);

        router.post(`/jobs/${job.id}/apply`, {}, {
            preserveScroll: true,
            onSuccess: async (page) => {
                const { flash } = page.props

                if(flash.completed) {
                    await showSuccess(
                        flash.completed,
                        2000
                    )
                }

                if(flash.message === 'Please upload your resume before applying!')
                {
                    const result = await showInfo(
                        flash.message, true, true, 'Upload Resume'
                    )
                    if (result.isConfirmed) router.visit('/resume')

                }else if (flash.message) {
                    await showInfo(flash.message)
                }
                setLoading(false)
            },
            onError: async (page) => {
                const {flash} = page.props

                if(flash.error) {
                    await showError(flash.error, 3000)
                }
            }
        })
    }, [user])

    return { applyForJob, loadingApply }
}
