import type { AdminApplicationData } from 'flarum/admin/AdminApplication';

declare module 'flarum/admin/AdminApplication' {
  export interface AdminApplicationData {
    boringAvatarThemes: string[];
  }
}
