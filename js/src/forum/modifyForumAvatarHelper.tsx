import app from 'flarum/forum/app';
import { extend, override } from 'flarum/common/extend';
import SessionDropdown from 'flarum/forum/components/SessionDropdown';
import svgAvatar from '../common/helpers/avatar';
import avatar from 'flarum/common/helpers/avatar';
import username from 'flarum/common/helpers/username';
import UserCard from 'flarum/forum/components/UserCard';
import AvatarEditor from 'flarum/forum/components/AvatarEditor';
import ItemList from 'flarum/common/utils/ItemList';
import type Mithril from 'mithril';

export default function modifyForumAvatarHelper() {
  extend(AvatarEditor.prototype, 'controlItems', function (items: ItemList<Mithril.Children>) {

    if (this.attrs.user.avatarIsGenerated?.()) {
      items.remove('remove');
    }
    
  });

}
