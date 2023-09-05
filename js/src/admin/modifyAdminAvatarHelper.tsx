import app from 'flarum/admin/app';
import { extend, override } from 'flarum/common/extend';
import SessionDropdown from 'flarum/admin/components/SessionDropdown';
import svgAvatar from '../common/helpers/avatar';
import username from 'flarum/common/helpers/username';

export default function modifyAdminAvatarHelper() {
  extend(SessionDropdown.prototype, 'getButtonContent', function (output) {
    const user = app.session.user;

    // Find the index of the default avatar in the output (the <span> element)
    const defaultAvatarIndex = output.findIndex((item) => item.tag === 'span' && item.attrs?.className?.includes('Avatar'));

    // If a default avatar was found, replace it with the new SVG avatar
    if (defaultAvatarIndex !== -1) {
      output[defaultAvatarIndex] = svgAvatar(user);
    }
  });
}
