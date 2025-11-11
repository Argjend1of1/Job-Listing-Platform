import {router, usePage} from "@inertiajs/react";
import {showError, showInfo, showSuccess, showWarning} from "@/reusableFunctions/alertUser.js";
import {useCallback, useState} from "react";
import {confirmAction} from "@/reusableFunctions/confirmAction.js";


export function useBookmark() {
    const {auth} = usePage().props;
    const {user} = auth;
    const [loadingBookmark, setLoading] = useState(false);

    const bookmarkJob = useCallback(async (job) => {
        if (!user) {
            await showWarning(
                "Please log in first.",
                "You need to be logged in to apply for this job.",
                "Login"
            );
            return;
        }
        const confirmation = await confirmAction(
            'Are you sure you want to bookmark this job ?',
            'Yes, I am sure!'
        );
        if(!confirmation) return;

        setLoading(true)

        router.post(`/jobs/${job.id}/bookmark`, {}, {
            preserveScroll: true,
            onSuccess: async (page) => {
                // we need the props here again because at this point when we return
                // from the callback the old data is still present at this point, even though
                // they are updated generally in here since we still are inside the request
                // we have the old values.
                const {flash} = page.props

                if (flash.completed) {
                    await showSuccess(
                        flash.completed,
                        2000
                    )
                }

                if (flash.message) {
                    const result = await showInfo(
                        flash.message, true, true, "Check Bookmarks"
                    )

                    if (result.isConfirmed) router.visit('/bookmarks')
                }
                setLoading(false)
            }
        })
    }, [user])

    const removeBookmark = useCallback(async (job) => {
        const confirmation = await confirmAction(
            'Are you sure you want to remove this bookmark ?',
            'Yes, I am sure!'
        );
        if(!confirmation) return;
        setLoading(true)

        router.delete(`/jobs/${job.id}/bookmark`, {
            onSuccess: (page) => {
                const{ flash } = page.props
                if(flash.completed)
                    showSuccess(flash.completed, 3000)

                setLoading(false)
            },
            onError: (page) => {
                const{ flash } = page.props

                if(flash.error)
                    showError(flash?.error, 3000)

                setLoading(false)
            }

        })
    }, [user])

    return {bookmarkJob, removeBookmark, loadingBookmark}
}
